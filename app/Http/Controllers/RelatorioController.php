<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use PDF;
use Posmat\Http\Controllers\FPDFController;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Models\DadoPessoal;
use Posmat\Models\Paises;
use Posmat\Models\Formacao;
use Posmat\Models\Estado;
use Posmat\Models\Cidade;
use Posmat\Models\DadoRecomendante;
use Posmat\Models\DadoAcademico;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaMotivacao;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\AreaPosMat;
use Posmat\Models\ProgramaPos;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;
use League\Csv\Writer;
use Storage;

/**
* Classe para visualização da página inicial.
*/
class RelatorioController extends BaseController
{

  public function getListaRelatorios()
  {

    $relatorio = new ConfiguraInscricaoPos();

    $relatorio_disponivel = $relatorio->retorna_edital_vigente();

    $programas_disponiveis = explode("_", $relatorio->retorna_inscricao_ativa()->programa);

    $nome_programa_pos = new ProgramaPos();

    foreach ($programas_disponiveis as $programa) {
     $programa_para_inscricao[$programa] = $nome_programa_pos->pega_programa_pos_mat($programa);
   }

   $programa = implode('/', $programa_para_inscricao);

   $arquivo_relatorio = "";

   $documentos_zipados = "";

   $monitoria = "";

   return view('templates.partials.coordenador.relatorio_pos')->with(compact('monitoria','relatorio_disponivel', 'programa', 'arquivo_relatorio','documentos_zipados'));
 }


  public function getArquivosRelatorios($id_inscricao_pos,$arquivo_relatorio,$documentos_zipados,$arquivo_dados_pessoais_bancario)
  {

  $relatorio = new ConfiguraInscricaoPos();

  $relatorio_disponivel = $relatorio->retorna_lista_para_relatorio();

  $monitoria = $id_inscricao_pos;

  return view('templates.partials.coordenador.relatorio_pos')->with(compact('monitoria','relatorio_disponivel','arquivo_relatorio','documentos_zipados','arquivo_dados_pessoais_bancario'));
  }


  public function geraRelatorio($id_inscricao_pos)
  {

    $relatorio = new ConfiguraInscricaoPos();

    $relatorio_disponivel = $relatorio->retorna_edital_vigente();

    $arquivos_temporarios = public_path("/relatorios/temporario");
    $arquivo_zip = public_path('/relatorios/zip/');

    $local_relatorios = public_path("/relatorios/edital_".$relatorio_disponivel->edital."/");

    File::isDirectory($local_relatorios) or File::makeDirectory($local_relatorios,077,true,true);

    $arquivo_zip = $local_relatorios.'zip/';

    File::isDirectory($arquivo_zip) or File::makeDirectory($arquivo_zip,077,true,true);

    $normalizeChars = array(
      'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
      'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
      'Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
      'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
      'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
      'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
      'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
      'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
    );


  // $csv_relatorio = Writer::createFromPath($local_relatorios.$arquivo_relatorio, 'w+');
  // $csv_dados_pessoais_bancarios = Writer::createFromPath($local_relatorios.$arquivo_dados_pessoais_bancario, 'w+');


    $finaliza = new FinalizaInscricao();
    $usuarios_finalizados = $finaliza->retorna_usuarios_relatorios($id_inscricao_pos);



    foreach ($usuarios_finalizados as $candidato) {

      $dados_candidato_para_relatorio = [];

      $dados_candidato_para_relatorio['edital'] = $relatorio_disponivel->edital;

      $dados_candidato_para_relatorio['id_aluno'] = $candidato->id_user;

      $dado_pessoal = new DadoPessoal();

      $dados_pessoais_candidato = $dado_pessoal->retorna_dados_pessoais($dados_candidato_para_relatorio['id_aluno']);

      $paises = new Paises();

      $estado = new Estado();

      $cidade = new Cidade();

      $data_hoje = (new Carbon())->format('Y-m-d');

      $idade_candidato = $data_hoje - $dados_pessoais_candidato->data_nascimento;

      $dados_candidato_para_relatorio['nome'] = $dados_pessoais_candidato->nome;

      $dados_candidato_para_relatorio['data_nascimento'] = Carbon::createFromFormat('Y-m-d', $dados_pessoais_candidato->data_nascimento)->format('d/m/Y');

      $dados_candidato_para_relatorio['idade'] = $data_hoje - $dados_pessoais_candidato->data_nascimento;

      $dados_candidato_para_relatorio['numerorg'] = $dados_pessoais_candidato->numerorg;

      $dados_candidato_para_relatorio['endereco'] = $dados_pessoais_candidato->endereco;

      $dados_candidato_para_relatorio['cep'] = $dados_pessoais_candidato->cep;

      $dados_candidato_para_relatorio['nome_pais'] = $paises->retorna_nome_pais_por_id($dados_pessoais_candidato->pais);

      $dados_candidato_para_relatorio['nome_estado'] = $estado->retorna_nome_estados_por_id($dados_pessoais_candidato->pais, $dados_pessoais_candidato->estado);
      
      $dados_candidato_para_relatorio['nome_cidade'] = $cidade->retorna_nome_cidade_por_id($dados_pessoais_candidato->cidade, $dados_pessoais_candidato->estado);

      $dados_candidato_para_relatorio['celular'] = $dados_pessoais_candidato->celular;

      $dado_academico = new DadoAcademico();

      $formacao = new Formacao();

      $dados_academicos_candidato = $dado_academico->retorna_dados_academicos($dados_candidato_para_relatorio['id_aluno']);

      $dados_candidato_para_relatorio['curso_graduacao'] = $dados_academicos_candidato->curso_graduacao;
      $dados_candidato_para_relatorio['tipo_curso_graduacao'] = $formacao->pega_tipo_formacao($dados_academicos_candidato->tipo_curso_graduacao,'Graduação');
      $dados_candidato_para_relatorio['instituicao_graduacao'] = $dados_academicos_candidato->instituicao_graduacao;
      $dados_candidato_para_relatorio['ano_conclusao_graduacao'] = $dados_academicos_candidato->ano_conclusao_graduacao;
      $dados_candidato_para_relatorio['curso_pos'] = $dados_academicos_candidato->curso_pos;
      $dados_candidato_para_relatorio['tipo_curso_pos'] = $formacao->pega_tipo_formacao($dados_academicos_candidato->tipo_curso_pos,'Pós-Graduação');
      $dados_candidato_para_relatorio['instituicao_pos'] = $dados_academicos_candidato->instituicao_pos;
      $dados_candidato_para_relatorio['ano_conclusao_pos'] = $dados_academicos_candidato->ano_conclusao_pos;

      $escolha_candidato = new EscolhaCandidato();

      $programa_pos = new ProgramaPos();

      $area_pos_mat = new AreaPosMat();

      $escolha_feita_candidato = $escolha_candidato->retorna_escolha_candidato($dados_candidato_para_relatorio['id_aluno'],$id_inscricao_pos);

      $dados_candidato_para_relatorio['programa_pretendido'] = $programa_pos->pega_programa_pos_mat($escolha_feita_candidato->programa_pretendido);
      $dados_candidato_para_relatorio['area_pos'] = $area_pos_mat->pega_area_pos_mat((int)$escolha_feita_candidato->area_pos);
      $dados_candidato_para_relatorio['interesse_bolsa'] = $escolha_feita_candidato->interesse_bolsa;
      $dados_candidato_para_relatorio['vinculo_empregaticio'] = $escolha_feita_candidato->vinculo_empregaticio;

      $contato_recomendante = new ContatoRecomendante();

      $contatos_indicados = $contato_recomendante->retorna_recomendante_candidato($dados_candidato_para_relatorio['id_aluno'],$id_inscricao_pos);

      $recomendantes_candidato = [];

      foreach ($contatos_indicados as $recomendante) {
        $dado_recomendante = new DadoRecomendante();
        $carta_recomendacao = new CartaRecomendacao();

        $carta_candidato = $carta_recomendacao->retorna_carta_recomendacao($recomendante->id_recomendante,$dados_candidato_para_relatorio['id_aluno'],$id_inscricao_pos);

        $usuario_recomendante = User::find($recomendante->id_recomendante);

        $recomendantes_candidato[$recomendante->id_recomendante]['nome'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome_recomendante;
        $recomendantes_candidato[$recomendante->id_recomendante]['email'] = $usuario_recomendante->email;
        $recomendantes_candidato[$recomendante->id_recomendante]['tempo_conhece_candidato'] = $carta_candidato->tempo_conhece_candidato;
        $recomendantes_candidato[$recomendante->id_recomendante]['circunstancia_1'] = $carta_candidato->circunstancia_1;
        $recomendantes_candidato[$recomendante->id_recomendante]['circunstancia_2'] = $carta_candidato->circunstancia_2;
        $recomendantes_candidato[$recomendante->id_recomendante]['circunstancia_3'] = $carta_candidato->circunstancia_3;
        $recomendantes_candidato[$recomendante->id_recomendante]['circunstancia_4'] = $carta_candidato->circunstancia_4;
        $recomendantes_candidato[$recomendante->id_recomendante]['circunstancia_outra'] = $carta_candidato->circunstancia_outra;
        $recomendantes_candidato[$recomendante->id_recomendante]['desempenho_academico'] = $carta_candidato->desempenho_academico;
        $recomendantes_candidato[$recomendante->id_recomendante]['capacidade_aprender'] = $carta_candidato->capacidade_aprender;
        $recomendantes_candidato[$recomendante->id_recomendante]['capacidade_trabalhar'] = $carta_candidato->capacidade_trabalhar;
        $recomendantes_candidato[$recomendante->id_recomendante]['criatividade'] = $carta_candidato->criatividade;
        $recomendantes_candidato[$recomendante->id_recomendante]['curiosidade'] = $carta_candidato->curiosidade;
        $recomendantes_candidato[$recomendante->id_recomendante]['esforco'] = $carta_candidato->esforco;
        $recomendantes_candidato[$recomendante->id_recomendante]['expressao_escrita'] = $carta_candidato->expressao_escrita;
        $recomendantes_candidato[$recomendante->id_recomendante]['expressao_oral'] = $carta_candidato->expressao_oral;
        $recomendantes_candidato[$recomendante->id_recomendante]['relacionamento'] = $carta_candidato->relacionamento;
        $recomendantes_candidato[$recomendante->id_recomendante]['antecedentes_academicos'] = $carta_candidato->antecedentes_academicos;
        $recomendantes_candidato[$recomendante->id_recomendante]['possivel_aproveitamento'] = $carta_candidato->possivel_aproveitamento;
        $recomendantes_candidato[$recomendante->id_recomendante]['informacoes_relevantes'] = $carta_candidato->informacoes_relevantes;
        $recomendantes_candidato[$recomendante->id_recomendante]['como_aluno'] = $carta_candidato->como_aluno;
        $recomendantes_candidato[$recomendante->id_recomendante]['como_orientando'] = $carta_candidato->como_orientando;
        $recomendantes_candidato[$recomendante->id_recomendante]['instituicao_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->instituicao_recomendante;
        $recomendantes_candidato[$recomendante->id_recomendante]['titulacao_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->titulacao_recomendante;
        $recomendantes_candidato[$recomendante->id_recomendante]['area_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->area_recomendante;
        $recomendantes_candidato[$recomendante->id_recomendante]['ano_titulacao'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->ano_titulacao;
        $recomendantes_candidato[$recomendante->id_recomendante]['inst_obtencao_titulo'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->inst_obtencao_titulo;
        $recomendantes_candidato[$recomendante->id_recomendante]['endereco_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->endereco_recomendante;

      }


      $carta_motivacao = new CartaMotivacao();

      $dados_carta_motivacao = $carta_motivacao->retorna_carta_motivacao($dados_candidato_para_relatorio['id_aluno'],$id_inscricao_pos);

      $dados_candidato_para_relatorio['motivacao'] = $dados_carta_motivacao->motivacao;

      if (is_null($dados_candidato_para_relatorio['area_pos'])) {
        $arquivo_relatorio_candidato = $local_relatorios.'Inscricao_'.$dados_candidato_para_relatorio['programa_pretendido'].'_'.str_replace(' ', '-', strtr($dados_candidato_para_relatorio['nome'], $normalizeChars)).'_'.$dados_candidato_para_relatorio['id_aluno'].'.pdf';
      }else{
        $arquivo_relatorio_candidato = $local_relatorios.'Inscricao_'.$dados_candidato_para_relatorio['programa_pretendido'].'_'.str_replace(' ', '-', strtr($dados_candidato_para_relatorio['area_pos'], $normalizeChars)).'_'.str_replace(' ', '-',strtr($dados_candidato_para_relatorio['nome'], $normalizeChars)).'_'.$dados_candidato_para_relatorio['id_aluno'].'.pdf';
      }
      
      $pdf = PDF::loadView('templates.partials.coordenador.pdf_relatorio', compact('dados_candidato_para_relatorio','recomendantes_candidato'));
      $pdf->save($arquivo_relatorio_candidato);
    }

    $programas_disponiveis = explode("_", $relatorio->retorna_inscricao_ativa()->programa);

    $nome_programa_pos = new ProgramaPos();

    foreach ($programas_disponiveis as $programa) {
       $programa_para_relatorio[$programa] = $nome_programa_pos->pega_programa_pos_mat($programa);
    }

    foreach ($programa_para_relatorio as $nome_programa) {
      $inscricoes_zipadas = 'Inscricoes_'.$nome_programa.'_Edital_'.$dados_candidato_para_relatorio['edital'].'.zip';

      $zip = new ZipArchive;

      if ( $zip->open( $arquivo_zip.$inscricoes_zipadas, ZipArchive::CREATE ) === true )
      {
             // Copy all the files from the folder and place them in the archive.
        
             foreach (glob( $local_relatorios.'Inscricao_'.$nome_programa.'*') as $fileName )
             {
                    $file = basename( $fileName );
                    $zip->addFile( $fileName, $file );
             }

             $zip->close();
      }
    }
    

    return $this->getArquivosRelatorios($id_inscricao_pos,$arquivo_relatorio,$documentos_zipados,$arquivo_dados_pessoais_bancario);
  }



  public function getRelatorioPos()
  {

    return view('templates.partials.coordenador.relatorio_pos');
  }

}