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
use Posmat\Models\Documento;
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
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
* Classe para visualização da página inicial.
*/
class RelatorioController extends BaseController
{

  protected $normalizeChars = array(
      'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
      'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
      'Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
      'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
      'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
      'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
      'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
      'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
    );

  public function ConsolidaCabecalhoCSV()
  {

    return $cabecalho = ["Nome","E-mail","Programa Pretendido"];
  }

  public function ConsolidaLocaisArquivos($edital)
  {

    $locais_arquivos = [];
    
    $locais_arquivos['arquivos_temporarios'] = public_path("/relatorios/temporario/");

    $locais_arquivos['ficha_inscricao'] = public_path("/relatorios/ficha_inscricao/");

    $locais_arquivos['local_relatorios'] = public_path("/relatorios/edital_".$edital."/");
    
    $locais_arquivos['arquivo_relatorio_csv'] = 'Inscricoes_Edital_'.$edital.'.csv';

    $locais_arquivos['local_documentos'] = storage_path('app/');

    $locais_arquivos['arquivo_zip'] = $locais_arquivos['local_relatorios'].'zip/';

    File::isDirectory($locais_arquivos['arquivos_temporarios']) or File::makeDirectory($locais_arquivos['arquivos_temporarios'],077,true,true);

    File::isDirectory($locais_arquivos['ficha_inscricao']) or File::makeDirectory($locais_arquivos['ficha_inscricao'],077,true,true);

    File::isDirectory($locais_arquivos['local_relatorios']) or File::makeDirectory($locais_arquivos['local_relatorios'],077,true,true);

    File::isDirectory($locais_arquivos['arquivo_zip']) or File::makeDirectory($locais_arquivos['arquivo_zip'],077,true,true);

    return $locais_arquivos;
  }


  public function ConsolidaDadosPessoais($id_candidato)
  {
    $consolida_dados = [];

    $dado_pessoal = new DadoPessoal();

    $dados_pessoais_candidato = $dado_pessoal->retorna_dados_pessoais($id_candidato);

    $paises = new Paises();

    $estado = new Estado();

    $cidade = new Cidade();

    $data_hoje = (new Carbon())->format('Y-m-d');

    $idade_candidato = $data_hoje - $dados_pessoais_candidato->data_nascimento;

    $consolida_dados['nome'] = $dados_pessoais_candidato->nome;

    $consolida_dados['data_nascimento'] = Carbon::createFromFormat('Y-m-d', $dados_pessoais_candidato->data_nascimento)->format('d/m/Y');

    $consolida_dados['idade'] = $data_hoje - $dados_pessoais_candidato->data_nascimento;

    $consolida_dados['numerorg'] = $dados_pessoais_candidato->numerorg;

    $consolida_dados['endereco'] = $dados_pessoais_candidato->endereco;

    $consolida_dados['cep'] = $dados_pessoais_candidato->cep;

    if (!is_null($dados_pessoais_candidato->pais)) {
      $consolida_dados['nome_pais'] = $paises->retorna_nome_pais_por_id($dados_pessoais_candidato->pais);
    }else{
      $consolida_dados['nome_pais'] = null;
    }

    if (!is_null($dados_pessoais_candidato->estado)) {
      $consolida_dados['nome_estado'] = $estado->retorna_nome_estados_por_id($dados_pessoais_candidato->pais, $dados_pessoais_candidato->estado);
    }else{
      $consolida_dados['nome_estado'] = null;
    }

    if (!is_null($dados_pessoais_candidato->cidade)) {
      $consolida_dados['nome_cidade'] = $cidade->retorna_nome_cidade_por_id($dados_pessoais_candidato->cidade, $dados_pessoais_candidato->estado);
    }else{
      $consolida_dados['nome_cidade'] = null;
    }

    $consolida_dados['celular'] = $dados_pessoais_candidato->celular;

    return $consolida_dados;
  }

  public function ConsolidaDadosAcademicos($id_candidato)
  {

    $consolida_academico = [];

    $dado_academico = new DadoAcademico();

    $formacao = new Formacao();

    $dados_academicos_candidato = $dado_academico->retorna_dados_academicos($id_candidato);

    $consolida_academico['curso_graduacao'] = $dados_academicos_candidato->curso_graduacao;
    $consolida_academico['tipo_curso_graduacao'] = $formacao->pega_tipo_formacao($dados_academicos_candidato->tipo_curso_graduacao,'Graduação');
    $consolida_academico['instituicao_graduacao'] = $dados_academicos_candidato->instituicao_graduacao;
    $consolida_academico['ano_conclusao_graduacao'] = $dados_academicos_candidato->ano_conclusao_graduacao;
    $consolida_academico['curso_pos'] = $dados_academicos_candidato->curso_pos;
    $consolida_academico['tipo_curso_pos'] = $formacao->pega_tipo_formacao($dados_academicos_candidato->tipo_curso_pos,'Pós-Graduação');
    $consolida_academico['instituicao_pos'] = $dados_academicos_candidato->instituicao_pos;
    $consolida_academico['ano_conclusao_pos'] = $dados_academicos_candidato->ano_conclusao_pos;

    return $consolida_academico;
  }

  public function ConsolidaEscolhaCandidato($id_candidato,$id_inscricao_pos)
  {
    $consolida_escolha = [];

    $escolha_candidato = new EscolhaCandidato();

    $programa_pos = new ProgramaPos();

    $area_pos_mat = new AreaPosMat();

    $escolha_feita_candidato = $escolha_candidato->retorna_escolha_candidato($id_candidato,$id_inscricao_pos);

    $consolida_escolha['programa_pretendido'] = $programa_pos->pega_programa_pos_mat($escolha_feita_candidato->programa_pretendido);
    $consolida_escolha['area_pos'] = $area_pos_mat->pega_area_pos_mat((int)$escolha_feita_candidato->area_pos);
    $consolida_escolha['interesse_bolsa'] = $escolha_feita_candidato->interesse_bolsa;
    $consolida_escolha['vinculo_empregaticio'] = $escolha_feita_candidato->vinculo_empregaticio;

    return $consolida_escolha;
  }

  public function ConsolidaNomeRecomendantes($contatos_indicados,$id_candidato,$id_inscricao_pos)
  {
    $nomes_recomendantes = [];

    foreach ($contatos_indicados as $recomendante) {
      
      $dado_recomendante = new DadoRecomendante();

      $usuario_recomendante = User::find($recomendante->id_recomendante);

      $nomes_recomendantes[$recomendante->id_recomendante]['nome'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome_recomendante;
      $nomes_recomendantes[$recomendante->id_recomendante]['email'] = $usuario_recomendante->email;
    }

    return $nomes_recomendantes;
  }

  public function ConsolidaCartaRecomendacao($contatos_indicados,$id_candidato,$id_inscricao_pos)
  {
    $consolida_recomendacao = [];

    foreach ($contatos_indicados as $recomendante) {
      $dado_recomendante = new DadoRecomendante();
      $carta_recomendacao = new CartaRecomendacao();

      $carta_candidato = $carta_recomendacao->retorna_carta_recomendacao($recomendante->id_recomendante,$id_candidato,$id_inscricao_pos);

      $usuario_recomendante = User::find($recomendante->id_recomendante);

      $consolida_recomendacao[$recomendante->id_recomendante]['nome'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome_recomendante;
      $consolida_recomendacao[$recomendante->id_recomendante]['email'] = $usuario_recomendante->email;
      $consolida_recomendacao[$recomendante->id_recomendante]['tempo_conhece_candidato'] = $carta_candidato->tempo_conhece_candidato;
      $consolida_recomendacao[$recomendante->id_recomendante]['circunstancia_1'] = $carta_candidato->circunstancia_1;
      $consolida_recomendacao[$recomendante->id_recomendante]['circunstancia_2'] = $carta_candidato->circunstancia_2;
      $consolida_recomendacao[$recomendante->id_recomendante]['circunstancia_3'] = $carta_candidato->circunstancia_3;
      $consolida_recomendacao[$recomendante->id_recomendante]['circunstancia_4'] = $carta_candidato->circunstancia_4;
      $consolida_recomendacao[$recomendante->id_recomendante]['circunstancia_outra'] = $carta_candidato->circunstancia_outra;
      $consolida_recomendacao[$recomendante->id_recomendante]['desempenho_academico'] = $carta_candidato->desempenho_academico;
      $consolida_recomendacao[$recomendante->id_recomendante]['capacidade_aprender'] = $carta_candidato->capacidade_aprender;
      $consolida_recomendacao[$recomendante->id_recomendante]['capacidade_trabalhar'] = $carta_candidato->capacidade_trabalhar;
      $consolida_recomendacao[$recomendante->id_recomendante]['criatividade'] = $carta_candidato->criatividade;
      $consolida_recomendacao[$recomendante->id_recomendante]['curiosidade'] = $carta_candidato->curiosidade;
      $consolida_recomendacao[$recomendante->id_recomendante]['esforco'] = $carta_candidato->esforco;
      $consolida_recomendacao[$recomendante->id_recomendante]['expressao_escrita'] = $carta_candidato->expressao_escrita;
      $consolida_recomendacao[$recomendante->id_recomendante]['expressao_oral'] = $carta_candidato->expressao_oral;
      $consolida_recomendacao[$recomendante->id_recomendante]['relacionamento'] = $carta_candidato->relacionamento;
      $consolida_recomendacao[$recomendante->id_recomendante]['antecedentes_academicos'] = $carta_candidato->antecedentes_academicos;
      $consolida_recomendacao[$recomendante->id_recomendante]['possivel_aproveitamento'] = $carta_candidato->possivel_aproveitamento;
      $consolida_recomendacao[$recomendante->id_recomendante]['informacoes_relevantes'] = $carta_candidato->informacoes_relevantes;
      $consolida_recomendacao[$recomendante->id_recomendante]['como_aluno'] = $carta_candidato->como_aluno;
      $consolida_recomendacao[$recomendante->id_recomendante]['como_orientando'] = $carta_candidato->como_orientando;
      $consolida_recomendacao[$recomendante->id_recomendante]['instituicao_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->instituicao_recomendante;
      $consolida_recomendacao[$recomendante->id_recomendante]['titulacao_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->titulacao_recomendante;
      $consolida_recomendacao[$recomendante->id_recomendante]['area_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->area_recomendante;
      $consolida_recomendacao[$recomendante->id_recomendante]['ano_titulacao'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->ano_titulacao;
      $consolida_recomendacao[$recomendante->id_recomendante]['inst_obtencao_titulo'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->inst_obtencao_titulo;
      $consolida_recomendacao[$recomendante->id_recomendante]['endereco_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->endereco_recomendante;
    }

    return $consolida_recomendacao;
  }

  public function ConsolidaCartaPorRecomendante($id_recomendante,$id_candidato,$id_inscricao_pos)
  {
    $consolida_recomendacao = [];

    $usuario_recomendante = User::find($id_recomendante);

    $dado_recomendante = new DadoRecomendante();
    $carta_recomendacao = new CartaRecomendacao();

    $carta_candidato = $carta_recomendacao->retorna_carta_recomendacao($id_recomendante,$id_candidato,$id_inscricao_pos);

    $consolida_recomendacao['nome'] = $dado_recomendante->retorna_dados_pessoais_recomendante($id_recomendante)->nome_recomendante;
    $consolida_recomendacao['email'] = $usuario_recomendante->email;
    $consolida_recomendacao['tempo_conhece_candidato'] = $carta_candidato->tempo_conhece_candidato;
    $consolida_recomendacao['circunstancia_1'] = $carta_candidato->circunstancia_1;
    $consolida_recomendacao['circunstancia_2'] = $carta_candidato->circunstancia_2;
    $consolida_recomendacao['circunstancia_3'] = $carta_candidato->circunstancia_3;
    $consolida_recomendacao['circunstancia_4'] = $carta_candidato->circunstancia_4;
    $consolida_recomendacao['circunstancia_outra'] = $carta_candidato->circunstancia_outra;
    $consolida_recomendacao['desempenho_academico'] = $carta_candidato->desempenho_academico;
    $consolida_recomendacao['capacidade_aprender'] = $carta_candidato->capacidade_aprender;
    $consolida_recomendacao['capacidade_trabalhar'] = $carta_candidato->capacidade_trabalhar;
    $consolida_recomendacao['criatividade'] = $carta_candidato->criatividade;
    $consolida_recomendacao['curiosidade'] = $carta_candidato->curiosidade;
    $consolida_recomendacao['esforco'] = $carta_candidato->esforco;
    $consolida_recomendacao['expressao_escrita'] = $carta_candidato->expressao_escrita;
    $consolida_recomendacao['expressao_oral'] = $carta_candidato->expressao_oral;
    $consolida_recomendacao['relacionamento'] = $carta_candidato->relacionamento;
    $consolida_recomendacao['antecedentes_academicos'] = $carta_candidato->antecedentes_academicos;
    $consolida_recomendacao['possivel_aproveitamento'] = $carta_candidato->possivel_aproveitamento;
    $consolida_recomendacao['informacoes_relevantes'] = $carta_candidato->informacoes_relevantes;
    $consolida_recomendacao['como_aluno'] = $carta_candidato->como_aluno;
    $consolida_recomendacao['como_orientando'] = $carta_candidato->como_orientando;
    $consolida_recomendacao['instituicao_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($id_recomendante)->instituicao_recomendante;
    $consolida_recomendacao['titulacao_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($id_recomendante)->titulacao_recomendante;
    $consolida_recomendacao['area_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($id_recomendante)->area_recomendante;
    $consolida_recomendacao['ano_titulacao'] = $dado_recomendante->retorna_dados_pessoais_recomendante($id_recomendante)->ano_titulacao;
    $consolida_recomendacao['inst_obtencao_titulo'] = $dado_recomendante->retorna_dados_pessoais_recomendante($id_recomendante)->inst_obtencao_titulo;
    $consolida_recomendacao['endereco_recomendante'] = $dado_recomendante->retorna_dados_pessoais_recomendante($id_recomendante)->endereco_recomendante;

    return $consolida_recomendacao;
  }

  public function ConsolidaIndicaoes($id_candidato, $id_inscricao_pos)
  {

    $contato_recomendante = new ContatoRecomendante();

    return $contato_recomendante->retorna_recomendante_candidato($id_candidato, $id_inscricao_pos);
  }

  public function ConsolidaCartaMotivacao($id_candidato, $id_inscricao_pos)
  {
    $carta_motivacao = new CartaMotivacao();

    $dados_carta_motivacao = $carta_motivacao->retorna_carta_motivacao($id_candidato,$id_inscricao_pos);

    return $dados_carta_motivacao->motivacao;
  }

  public function ConsolidaNomeArquivos($local_arquivos_temporarios, $local_arquivos_definitivos, $dados_candidato_para_relatorio)
  {
    $nome_arquivos = [];

    // dd($local_arquivos_temporarios);

    if (is_null($dados_candidato_para_relatorio['area_pos'])) {
      $nome_arquivos['arquivo_relatorio_candidato_temporario'] = $local_arquivos_temporarios.$dados_candidato_para_relatorio['programa_pretendido'].'_'.str_replace(' ', '-', strtr($dados_candidato_para_relatorio['nome'], $this->normalizeChars)).'_'.$dados_candidato_para_relatorio['id_aluno'].'.pdf';
      $nome_arquivos['arquivo_relatorio_candidato_final'] = $local_arquivos_definitivos.'Inscricao_'.$dados_candidato_para_relatorio['programa_pretendido'].'_'.str_replace(' ', '-', strtr($dados_candidato_para_relatorio['nome'], $this->normalizeChars)).'_'.$dados_candidato_para_relatorio['id_aluno'].'.pdf';
      }else{
        $nome_arquivos['arquivo_relatorio_candidato_temporario'] = $local_arquivos_temporarios.$dados_candidato_para_relatorio['programa_pretendido'].'_'.str_replace(' ', '-', strtr($dados_candidato_para_relatorio['area_pos'], $this->normalizeChars)).'_'.str_replace(' ', '-',strtr($dados_candidato_para_relatorio['nome'], $this->normalizeChars)).'_'.$dados_candidato_para_relatorio['id_aluno'].'.pdf';
        $nome_arquivos['arquivo_relatorio_candidato_final'] = $local_arquivos_definitivos.'Inscricao_'.$dados_candidato_para_relatorio['programa_pretendido'].'_'.str_replace(' ', '-', strtr($dados_candidato_para_relatorio['area_pos'], $this->normalizeChars)).'_'.str_replace(' ', '-',strtr($dados_candidato_para_relatorio['nome'], $this->normalizeChars)).'_'.$dados_candidato_para_relatorio['id_aluno'].'.pdf';
      }

      return $nome_arquivos;
  }

  public function ConsolidaDocumentosPDF($id_candidato, $local_documentos, $id_inscricao_pos)
  {

    $nome_uploads = [];

    $documento = new Documento();

    $nome_documento_banco = $local_documentos.$documento->retorna_documento($id_candidato,$id_inscricao_pos)->nome_arquivo;

    $nome_historico_banco = $local_documentos.$documento->retorna_historico($id_candidato,$id_inscricao_pos)->nome_arquivo;

    if (File::extension($nome_documento_banco) != 'pdf')
      {
        $nome_historico_pdf = str_replace(File::extension($nome_documento_banco),'pdf', $nome_documento_banco);
        $converte_jpg = new Process('convert '.$nome_documento_banco.' -resize 575x823^\> -gravity center -background white -extent 595x842 '.$nome_historico_pdf);
        $converte_jpg->run();
        
        if (!$converte_jpg->isSuccessful()) {
          throw new ProcessFailedException($converte_jpg);
        }

        // echo $converte_jpg->getOutput();
      }

      if (File::extension($nome_historico_banco) != 'pdf')
      {
        $nome_historico_pdf = str_replace(File::extension($nome_historico_banco),'pdf', $nome_historico_banco);
        $converte_jpg = new Process('convert '.$nome_historico_banco.' -resize 575x823^\> -gravity center -background white -extent 595x842 '.$nome_historico_pdf);
        $converte_jpg->run();
        if (!$converte_jpg->isSuccessful()) {
          throw new ProcessFailedException($converte_jpg);
        }

        // echo $converte_jpg->getOutput();
      }

    $nome_uploads['documento_pdf'] = str_replace(File::extension($nome_documento_banco),'pdf', $nome_documento_banco);
    $nome_uploads['historico_pdf'] = str_replace(File::extension($nome_historico_banco),'pdf', $nome_historico_banco);

    return $nome_uploads;
  }

  public function ConsolidaFichaRelatorio($nome_arquivos, $nome_uploads)
  {
    $process = new Process('pdftk '.$nome_arquivos['arquivo_relatorio_candidato_temporario'].' '.$nome_uploads['documento_pdf'].' '.$nome_uploads['historico_pdf'].' cat output '.$nome_arquivos['arquivo_relatorio_candidato_final']);

    $process->run();

    if (!$process->isSuccessful()) {
      throw new ProcessFailedException($process);
    }

    // echo $process->getOutput();
  }

  public function ConsolidaArquivosZIP($arquivo_zip, $local_relatorios, $programas)
  {
    
    $programas_disponiveis = explode("_", $programas);

    $nome_programa_pos = new ProgramaPos();

    foreach ($programas_disponiveis as $programa) {
       $programa_para_relatorio[$programa] = $nome_programa_pos->pega_programa_pos_mat($programa);
    }

    foreach ($programa_para_relatorio as $nome_programa) {
      $inscricoes_zipadas = 'Inscricoes_'.$nome_programa.'_Edital_'.$relatorio_disponivel->edital.'.zip';
      $arquivos_zipados_para_view[$nome_programa] = $inscricoes_zipadas;

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

    return $arquivos_zipados_para_view;
  }

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

   $arquivos_zipados_para_view = "";

   $documentos_zipados = "";

   $relatorio_csv = "";

   $monitoria = "";

   return view('templates.partials.coordenador.relatorio_pos_edital_vigente')->with(compact('monitoria','relatorio_disponivel', 'programa', 'arquivos_zipados_para_view','relatorio_csv'));
  }

   public function getListaRelatoriosAnteriores()
  {

    $relatorio = new ConfiguraInscricaoPos();

    $relatorios_anteriores = $relatorio->retorna_lista_para_relatorio();

    $arquivos_zipados_para_view = "";

    $documentos_zipados = "";

    $relatorio_csv = "";

    $monitoria = "";

    return view('templates.partials.coordenador.relatorio_pos_editais_anteriores')->with(compact('monitoria','relatorios_anteriores', 'arquivos_zipados_para_view','relatorio_csv'));
 }


  public function getArquivosRelatorios($id_inscricao_pos,$arquivos_zipados_para_view,$relatorio_csv)
  {

  $relatorio = new ConfiguraInscricaoPos();

  $relatorio_disponivel = $relatorio->retorna_edital_vigente();

  $programas_disponiveis = explode("_", $relatorio->retorna_inscricao_ativa()->programa);

  $nome_programa_pos = new ProgramaPos();

    foreach ($programas_disponiveis as $programa) {
     $programa_para_inscricao[$programa] = $nome_programa_pos->pega_programa_pos_mat($programa);
    }

  $programa = implode('/', $programa_para_inscricao);
  $monitoria = $id_inscricao_pos;

  return view('templates.partials.coordenador.relatorio_pos_edital_vigente')->with(compact('monitoria','programa','relatorio_disponivel','arquivos_zipados_para_view','relatorio_csv'));
  }


  public function geraRelatorio($id_inscricao_pos)
  {

    $relatorio = new ConfiguraInscricaoPos();

    $relatorios_disponivel = $relatorio->retorna_edital_vigente();

    $locais_arquivos = $this->ConsolidaLocaisArquivos($relatorio_disponivel->edital);

    $relatorio_csv = Writer::createFromPath($locais_arquivos['local_relatorios'].$locais_arquivos['arquivo_relatorio_csv'], 'w+');
    

    $relatorio_csv->insertOne($this->ConsolidaCabecalhoCSV());


    $finaliza = new FinalizaInscricao();
    $usuarios_finalizados = $finaliza->retorna_usuarios_relatorios($id_inscricao_pos);



    foreach ($usuarios_finalizados as $candidato) {

      $linha_arquivo = [];

      $dados_candidato_para_relatorio = [];

      $dados_candidato_para_relatorio['edital'] = $relatorio_disponivel->edital;

      $dados_candidato_para_relatorio['id_aluno'] = $candidato->id_user;

      foreach ($this->ConsolidaDadosPessoais($dados_candidato_para_relatorio['id_aluno']) as $key => $value) {
         $dados_candidato_para_relatorio[$key] = $value;
      }

      $linha_arquivo['nome'] = $dados_candidato_para_relatorio['nome'];

      $linha_arquivo['email'] = User::find($dados_candidato_para_relatorio['id_aluno'])->email;

      foreach ($this->ConsolidaDadosAcademicos($dados_candidato_para_relatorio['id_aluno']) as $key => $value) {
        $dados_candidato_para_relatorio[$key] = $value;
      }

      foreach ($this->ConsolidaEscolhaCandidato($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos) as $key => $value) {
        $dados_candidato_para_relatorio[$key] = $value;
      }

      $linha_arquivo['programa_pretendido'] = $dados_candidato_para_relatorio['programa_pretendido'];


      $contatos_indicados = $this->ConsolidaIndicaoes($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos);

      foreach ($contatos_indicados  as $id ) {
        $recomendantes_candidato[$id->id_recomendante] = $this->ConsolidaCartaPorRecomendante($id->id_recomendante,$dados_candidato_para_relatorio['id_aluno'],$id_inscricao_pos);
      }

      $dados_candidato_para_relatorio['motivacao'] = $this->ConsolidaCartaMotivacao($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos);

      $nome_arquivos = $this->ConsolidaNomeArquivos($locais_arquivos['arquivos_temporarios'], $locais_arquivos['local_relatorios'], $dados_candidato_para_relatorio);
      
      $pdf = PDF::loadView('templates.partials.coordenador.pdf_relatorio', compact('dados_candidato_para_relatorio','recomendantes_candidato'));
      $pdf->save($nome_arquivos['arquivo_relatorio_candidato_temporario']);

      $nome_uploads = $this->ConsolidaDocumentosPDF($dados_candidato_para_relatorio['id_aluno'], $locais_arquivos['local_documentos'], $id_inscricao_pos);

      $this->ConsolidaFichaRelatorio($nome_arquivos, $nome_uploads);

      $relatorio_csv->insertOne($linha_arquivo);
      
    }

    $arquivos_zipados_para_view = $this->ConsolidaArquivosZIP($locais_arquivos['arquivo_zip'], $locais_arquivos['local_relatorios'], $relatorios_disponivel->programa);
    

    return $this->getArquivosRelatorios($id_inscricao_pos,$arquivos_zipados_para_view,$locais_arquivos['arquivo_relatorio_csv']);
  }

  public function geraFichaIndividual($id_aluno)
  {

      $relatorio = new ConfiguraInscricaoPos();

      $relatorio_disponivel = $relatorio->retorna_edital_vigente();

      $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

      $locais_arquivos = $this->ConsolidaLocaisArquivos($relatorio_disponivel->edital);

      $dados_candidato_para_relatorio['edital'] = $relatorio_disponivel->edital;

      $dados_candidato_para_relatorio['id_aluno'] = $id_aluno;

      foreach ($this->ConsolidaDadosPessoais($dados_candidato_para_relatorio['id_aluno']) as $key => $value) {
         $dados_candidato_para_relatorio[$key] = $value;
      }

      foreach ($this->ConsolidaDadosAcademicos($dados_candidato_para_relatorio['id_aluno']) as $key => $value) {
        $dados_candidato_para_relatorio[$key] = $value;
      }

      foreach ($this->ConsolidaEscolhaCandidato($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos) as $key => $value) {
        $dados_candidato_para_relatorio[$key] = $value;
      }

      $contatos_indicados = $this->ConsolidaIndicaoes($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos);

      foreach ($contatos_indicados  as $id ) {
        $recomendantes_candidato[$id->id_recomendante] = $this->ConsolidaCartaPorRecomendante($id->id_recomendante,$dados_candidato_para_relatorio['id_aluno'],$id_inscricao_pos);
      }

      $dados_candidato_para_relatorio['motivacao'] = $this->ConsolidaCartaMotivacao($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos);

      $nome_arquivos = $this->ConsolidaNomeArquivos($locais_arquivos['arquivos_temporarios'], $locais_arquivos['local_relatorios'], $dados_candidato_para_relatorio);
      
      $pdf = PDF::loadView('templates.partials.coordenador.pdf_relatorio', compact('dados_candidato_para_relatorio','recomendantes_candidato'));
      $pdf->save($nome_arquivos['arquivo_relatorio_candidato_temporario']);

      $nome_uploads = $this->ConsolidaDocumentosPDF($dados_candidato_para_relatorio['id_aluno'], $locais_arquivos['local_documentos'], $id_inscricao_pos);

      $this->ConsolidaFichaRelatorio($nome_arquivos, $nome_uploads);

      return $nome_arquivos['arquivo_relatorio_candidato_final'];
  }

  public function getArquivosRelatoriosAnteriores($id_inscricao_pos,$arquivos_zipados_para_view,$relatorio_csv)
  {

    $relatorio = new ConfiguraInscricaoPos();

    $relatorios_anteriores = $relatorio->retorna_lista_para_relatorio();

    $monitoria = $id_inscricao_pos;

    return redirect()->back()->with(compact('monitoria','relatorios_anteriores','arquivos_zipados_para_view','relatorio_csv'));
  }


  public function geraRelatoriosAnteriores($id_inscricao_pos)
  {

    $relatorio_disponivel = ConfiguraInscricaoPos::find($id_inscricao_pos);

    $locais_arquivos = $this->ConsolidaLocaisArquivos($relatorio_disponivel['edital']);

    $relatorio_csv = Writer::createFromPath($locais_arquivos['local_relatorios'].$locais_arquivos['arquivo_relatorio_csv'], 'w+');

    $relatorio_csv->insertOne($this->ConsolidaCabecalhoCSV());


    $finaliza = new FinalizaInscricao();
    $usuarios_finalizados = $finaliza->retorna_usuarios_relatorios($id_inscricao_pos);


    foreach ($usuarios_finalizados as $candidato) {

      $linha_arquivo = [];

      $dados_candidato_para_relatorio = [];

      $dados_candidato_para_relatorio['edital'] = $relatorio_disponivel->edital;

      $dados_candidato_para_relatorio['id_aluno'] = $candidato->id_user;

      foreach ($this->ConsolidaDadosPessoais($dados_candidato_para_relatorio['id_aluno']) as $key => $value) {
         $dados_candidato_para_relatorio[$key] = $value;
      }

      $linha_arquivo['nome'] = $dados_candidato_para_relatorio['nome'];

      $linha_arquivo['email'] = User::find($dados_candidato_para_relatorio['id_aluno'])->email;

      foreach ($thiss->ConsolidaDadosAcademicos($dados_candidato_para_relatorio['id_aluno']) as $key => $value) {
        $dados_candidato_para_relatorio[$key] = $value;
      }

      foreach ($this->ConsolidaEscolhaCandidato($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos) as $key => $value) {
        $dados_candidato_para_relatorio[$key] = $value;
      }

      $linha_arquivo['programa_pretendido'] = $dados_candidato_para_relatorio['programa_pretendido'];


      $contatos_indicados = $this->ConsolidaIndicaoes($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos);

      foreach ($contatos_indicados  as $id ) {
        $recomendantes_candidato[$id->id_recomendante] = $this->ConsolidaCartaPorRecomendante($id->id_recomendante,$dados_candidato_para_relatorio['id_aluno'],$id_inscricao_pos);
      }

      $dados_candidato_para_relatorio['motivacao'] = $this->ConsolidaCartaMotivacao($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos);

      $nome_arquivos = $this->ConsolidaNomeArquivos($locais_arquivos['arquivos_temporarios'], $locais_arquivos['local_relatorios'], $dados_candidato_para_relatorio);
      
      $pdf = PDF::loadView('templates.partials.coordenador.pdf_relatorio', compact('dados_candidato_para_relatorio','recomendantes_candidato'));
      $pdf->save($nome_arquivos['arquivo_relatorio_candidato_temporario']);

      $nome_uploads = $this->ConsolidaDocumentosPDF($dados_candidato_para_relatorio['id_aluno'], $locais_arquivos['local_documentos'], $id_inscricao_pos);

      $this->ConsolidaFichaRelatorio($nome_arquivos, $nome_uploads);

      $relatorio_csv->insertOne($linha_arquivo);
      
    }

    $arquivos_zipados_para_view = $this->ConsolidaArquivosZIP($locais_arquivos['arquivo_zip'], $locais_arquivos['local_relatorios'], $relatorio_disponivel->programa);

    return $this->getArquivosRelatoriosAnteriores($id_inscricao_pos,$arquivos_zipados_para_view,$locais_arquivos['arquivo_relatorio_csv']);
  }


  public function getRelatorioPos()
  {

    return view('templates.partials.coordenador.relatorio_pos_edital_vigente');
  }

  public function geraFichaInscricao($id_aluno, $id_inscricao_pos)
  {

    $relatorio = new ConfiguraInscricaoPos();

    $relatorio_disponivel = $relatorio->retorna_edital_vigente();

    $locais_arquivos = $this->ConsolidaLocaisArquivos($relatorio_disponivel->edital);

    $dados_candidato_para_relatorio = [];

    $dados_candidato_para_relatorio['edital'] = $relatorio_disponivel->edital;

    $dados_candidato_para_relatorio['id_aluno'] = $id_aluno;

    foreach ($this->ConsolidaDadosPessoais($dados_candidato_para_relatorio['id_aluno']) as $key => $value) {
       $dados_candidato_para_relatorio[$key] = $value;
    }

    foreach ($this->ConsolidaDadosAcademicos($dados_candidato_para_relatorio['id_aluno']) as $key => $value) {
        $dados_candidato_para_relatorio[$key] = $value;
    }

    foreach ($this->ConsolidaEscolhaCandidato($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos) as $key => $value) {
      $dados_candidato_para_relatorio[$key] = $value;
    }


    $contatos_indicados = $this->ConsolidaIndicaoes($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos);


    $dados_candidato_para_relatorio['motivacao'] = $this->ConsolidaCartaMotivacao($dados_candidato_para_relatorio['id_aluno'], $id_inscricao_pos);

    $recomendantes_candidato = $this->ConsolidaNomeRecomendantes($contatos_indicados,$id_aluno,$id_inscricao_pos);

    $nome_arquivos = $this->ConsolidaNomeArquivos($locais_arquivos['arquivos_temporarios'], $locais_arquivos['ficha_inscricao'], $dados_candidato_para_relatorio);
    
    $pdf = PDF::loadView('templates.partials.candidato.pdf_ficha_inscricao', compact('dados_candidato_para_relatorio','recomendantes_candidato'));
    $pdf->save($nome_arquivos['arquivo_relatorio_candidato_temporario']);

    $nome_uploads = $this->ConsolidaDocumentosPDF($dados_candidato_para_relatorio['id_aluno'], $locais_arquivos['local_documentos'], $id_inscricao_pos);

    $this->ConsolidaFichaRelatorio($nome_arquivos, $nome_uploads);

    return $nome_arquivos['arquivo_relatorio_candidato_final'];
  }

}