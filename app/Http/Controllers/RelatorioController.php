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
use Posmat\Models\Estado;
use Posmat\Models\Cidade;
use Posmat\Models\DadoAcademico;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaMotivacao;
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

       	$arquivo_relatorio = "Relatorio_inscritos_".$id_inscricao_pos.".csv";
              $arquivo_dados_pessoais_bancario = "Dados_pessoais-bancarios_".$id_inscricao_pos.".csv";
              $local_relatorios = 'relatorios/csv/';
              $local_documentos = storage_path('app/');
              $arquivos_temporarios = public_path("/relatorios/temporario");
              $arquivo_zip = public_path('/relatorios/zip/');

              $documentos_zipados = 'Documentos_'.$id_inscricao_pos.'.zip';


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

                $dados_candidato_para_relatorio['nome'] = $dados_pessoais_candidato->nome;

                $dados_candidato_para_relatorio['data_nascimento'] = Carbon::createFromFormat('Y-m-d', $dados_pessoais_candidato->data_nascimento)->format('d/m/Y');

                $dados_candidato_para_relatorio['numerorg'] = $dados_pessoais_candidato->numerorg;

                $dados_candidato_para_relatorio['endereco'] = $dados_pessoais_candidato->endereco;

                $dados_candidato_para_relatorio['cep'] = $dados_pessoais_candidato->cep;

                $dados_candidato_para_relatorio['nome_pais'] = $paises->retorna_nome_pais_por_id($dados_pessoais_candidato->pais);

                $dados_candidato_para_relatorio['nome_estado'] = $estado->retorna_nome_estados_por_id($dados_pessoais_candidato->pais, $dados_pessoais_candidato->estado);
                     
                $dados_candidato_para_relatorio['nome_cidade'] = $cidade->retorna_nome_cidade_por_id($dados_pessoais_candidato->cidade, $dados_pessoais_candidato->estado);

                $dados_candidato_para_relatorio['celular'] = $dados_pessoais_candidato->celular;

                $dado_academico = new DadoAcademico();

                $dados_academicos_candidato = $dado_academico->retorna_dados_academicos($dados_candidato_para_relatorio['id_aluno']);

                $dados_candidato_para_relatorio['curso_graduacao'] = $dados_academicos_candidato->curso_graduacao;
                $dados_candidato_para_relatorio['tipo_curso_graduacao'] = $dados_academicos_candidato->tipo_curso_graduacao;
                $dados_candidato_para_relatorio['instituicao_graduacao'] = $dados_academicos_candidato->instituicao_graduacao;
                $dados_candidato_para_relatorio['ano_conclusao_graduacao'] = $dados_academicos_candidato->ano_conclusao_graduacao;
                $dados_candidato_para_relatorio['curso_pos'] = $dados_academicos_candidato->curso_pos;
                $dados_candidato_para_relatorio['tipo_curso_pos'] = $dados_academicos_candidato->tipo_curso_pos;
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

                $i=1;
                foreach ($contatos_indicados as $recomendante) {
                  $dados_candidato_para_relatorio['recomendante_'.$i] = $recomendante->id_recomendante;
                  $i++;
                }


                $carta_motivacao = new CartaMotivacao();

                $dados_carta_motivacao = $carta_motivacao->retorna_carta_motivacao($dados_candidato_para_relatorio['id_aluno'],$id_inscricao_pos);

                $dados_candidato_para_relatorio['motivacao'] = $dados_carta_motivacao->motivacao;
                
              $local_relatorios = public_path("/relatorios/edital_".$dados_candidato_para_relatorio['edital']."/");

        File::isDirectory($local_relatorios) or File::makeDirectory($local_relatorios,077,true,true);
        

        $arquivo_relatorio = $local_relatorios.'Relatorio_'.$dados_candidato_para_relatorio['id_aluno'].'.pdf';
                $pdf = PDF::loadView('templates.partials.coordenador.pdf', compact('dados_candidato_para_relatorio'));
                $pdf->save($arquivo_relatorio);
                
              }
              // dd();
              dd($dados_candidato_para_relatorio);
              return $this->getArquivosRelatorios($id_inscricao_pos,$arquivo_relatorio,$documentos_zipados,$arquivo_dados_pessoais_bancario);

       
    }

	

	public function getRelatorioPos()
	{

		return view('templates.partials.coordenador.relatorio_pos');
	}

}