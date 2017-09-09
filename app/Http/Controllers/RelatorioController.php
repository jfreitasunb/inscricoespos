<?php

namespace Monitoriamat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use Carbon\Carbon;
use Monitoriamat\Models\User;
use Monitoriamat\Models\ConfiguraInscricao;
use Monitoriamat\Models\DadoPessoal;
use Monitoriamat\Models\DadoBancario;
use Monitoriamat\Models\Documento;
use Monitoriamat\Models\DadoAcademico;
use Monitoriamat\Models\DisciplinaMat;
use Monitoriamat\Models\DisciplinaMonitoria;
use Monitoriamat\Models\EscolhaMonitoria;
use Monitoriamat\Models\HorarioEscolhido;
use Monitoriamat\Models\AtuacaoMonitoria;
use Monitoriamat\Models\FinalizaEscolha;
use Illuminate\Http\Request;
use Monitoriamat\Mail\EmailVerification;
use Monitoriamat\Http\Controllers\Controller;
use Monitoriamat\Http\Controllers\AuthController;
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

		$relatorio = new ConfiguraInscricao();

		$relatorio_disponivel = $relatorio->retorna_lista_para_relatorio();

              $arquivo_relatorio = "";

              $documentos_zipados = "";

              $monitoria = "";

		return view('templates.partials.coordenador.relatorio_monitoria')->with(compact('monitoria','relatorio_disponivel', 'arquivo_relatorio','documentos_zipados'));
	}


       public function getArquivosRelatorios($id_monitoria,$arquivo_relatorio,$documentos_zipados,$arquivo_dados_pessoais_bancario)
       {

              $relatorio = new ConfiguraInscricao();

              $relatorio_disponivel = $relatorio->retorna_lista_para_relatorio();

              $monitoria = $id_monitoria;

              return view('templates.partials.coordenador.relatorio_monitoria')->with(compact('monitoria','relatorio_disponivel','arquivo_relatorio','documentos_zipados','arquivo_dados_pessoais_bancario'));
       }


	public function geraRelatorio($id_monitoria)
       {

       	$arquivo_relatorio = "Relatorio_inscritos_".$id_monitoria.".csv";
              $arquivo_dados_pessoais_bancario = "Dados_pessoais-bancarios_".$id_monitoria.".csv";
              $local_relatorios = 'relatorios/csv/';
              $local_documentos = storage_path('app/');
              $arquivos_temporarios = public_path("/relatorios/temporario");
              $arquivo_zip = public_path('/relatorios/zip/');

              $documentos_zipados = 'Documentos_'.$id_monitoria.'.zip';


              $csv_relatorio = Writer::createFromPath($local_relatorios.$arquivo_relatorio, 'w+');
              $csv_dados_pessoais_bancarios = Writer::createFromPath($local_relatorios.$arquivo_dados_pessoais_bancario, 'w+');


              $relatorio = new FinalizaEscolha();
              $usuarios_finalizados = $relatorio->retorna_usuarios_relatorios($id_monitoria);

              $cabecalho = ["Nome","E-mail","Celular","Curso de Graduação", "IRA", "Tipo de Monitoria", "Monitor Convidado", "Nome do Professor", "Escolhas", "Horários", "Atuações Anteoriores"];

              $cabecalho_dados_pessoais_bancario = ["Nome","E-mail","Matrícula","Celular","CPF", "Banco", "Número", "Agência", "Conta Corrente"];

              $csv_relatorio->insertOne($cabecalho);
              $csv_dados_pessoais_bancarios->insertOne($cabecalho_dados_pessoais_bancario);


              foreach ($usuarios_finalizados as $usuario) {

                     $linha_arquivo = [];
       		$id_user = $usuario->id_user;

                     $user = New User();

                     $email = $user->find($id_user)->email;
                     $matricula = $user->find($id_user)->login;

       		$dado_pessoal = new DadoPessoal();
       		$dados_pessoais = $dado_pessoal->retorna_dados_pessoais($id_user);

                     $linha_arquivo['nome'] = $dados_pessoais->nome;

                     $linha_arquivo_DPB['nome'] = $dados_pessoais->nome;
                     
                     $linha_arquivo['email'] = $email;

                     $linha_arquivo_DPB['email'] = $email;
                     $linha_arquivo_DPB['matricula'] = $matricula;

                     $linha_arquivo['celular'] = $dados_pessoais->celular;

                     $linha_arquivo_DPB['celular'] = $dados_pessoais->celular;
                     $linha_arquivo_DPB['CPF'] = $dados_pessoais->cpf;

                     $dado_bancario = new DadoBancario();

                     $dados_bancarios = $dado_bancario->retorna_dados_bancarios($id_user);

                     if (!is_null($dados_bancarios)) {
                            $linha_arquivo_DPB['nome_banco'] = $dados_bancarios->nome_banco;
                            $linha_arquivo_DPB['numero_banco'] = $dados_bancarios->numero_banco;
                            $linha_arquivo_DPB['agencia_bancaria'] = $dados_bancarios->agencia_bancaria;
                            $linha_arquivo_DPB['numero_conta_corrente'] = $dados_bancarios->numero_conta_corrente;
                     }
                     

       		$dado_academico = new DadoAcademico();

       		$dados_academicos = $dado_academico->retorna_dados_academicos($id_user);

                     $linha_arquivo['curso_graduacao'] = $dados_academicos->curso_graduacao;

                     $linha_arquivo['ira'] = $dados_academicos->ira;

                     $linha_arquivo['tipo_monitoria'] = $usuario->tipo_monitoria;

                     if ($dados_academicos->monitor_convidado) {
                            $linha_arquivo['monitor_convidado'] = "Sim";

                            $linha_arquivo['nome_professor'] = $dados_academicos->nome_professor;

                     }else{
                            
                            $linha_arquivo['monitor_convidado'] = "Não";

                            $linha_arquivo['nome_professor'] = "";
                     }
                     


       		$escolheu = new EscolhaMonitoria();

       		$escolhas_candidato = $escolheu->retorna_escolha_monitoria($id_user,$id_monitoria);

       		$disciplina = new DisciplinaMat();


       		for ($i=0; $i < sizeof($escolhas_candidato); $i++) { 
       			
       			$codigo = $escolhas_candidato[$i]->escolha_aluno;

       			$nome_disciplina = $disciplina->retorna_nome_pelo_codigo($codigo);

       			$nome = $nome_disciplina[0]->nome;

       			$linha_arquivo['escolha_'.($i+1)] = $nome.",".$escolhas_candidato[$i]->mencao_aluno;

       		}

       		$horario = new HorarioEscolhido();

       		$horarios_escolhidos = $horario->retorna_horarios_escolhidos($id_user,$id_monitoria);

       		for ($j=0; $j < sizeof($horarios_escolhidos); $j++) { 
       			
       			$linha_arquivo['horario'.($j+1)] = $horarios_escolhidos[$j]->dia_semana.",".$horarios_escolhidos[$j]->horario_monitoria;
       		}

                     $atuacoes = new AtuacaoMonitoria();
                     $lista_de_atuacoes = $atuacoes->retorna_atuacao_monitoria($id_user);

                     for ($l=0; $l < sizeof($lista_de_atuacoes); $l++) { 
                            $linha_arquivo['atuou_monitoria'.($l+1)] = $lista_de_atuacoes[$l]->atuou_monitoria;
                     }

                     $csv_relatorio->insertOne($linha_arquivo);
                     $csv_dados_pessoais_bancarios->insertOne($linha_arquivo_DPB);

                     $documento = new Documento();

                     $nome_historico_banco = $local_documentos.$documento->retorna_arquivo_enviado($id_user)->nome_arquivo;

                     $nome_historico = $arquivos_temporarios."/".str_replace(' ', '_', $dados_pessoais->nome).".".File::extension($nome_historico_banco);

                     File::copy($nome_historico_banco,$nome_historico);
              }


              // Create "MyCoolName.zip" file in public directory of project.
              $zip = new ZipArchive;

              if ( $zip->open( $arquivo_zip.$documentos_zipados, ZipArchive::CREATE ) === true )
              {
                     // Copy all the files from the folder and place them in the archive.
                     foreach (glob( $arquivos_temporarios.'/*') as $fileName )
                     {
                            $file = basename( $fileName );
                            $zip->addFile( $fileName, $file );
                     }

                     $zip->close();
              }

              // File::cleanDirectory($arquivos_temporarios);

              return $this->getArquivosRelatorios($id_monitoria,$arquivo_relatorio,$documentos_zipados,$arquivo_dados_pessoais_bancario);

       
    }

	

	public function getRelatorioMonitoria()
	{

		return view('templates.partials.coordenador.relatorio_monitoria');
	}

}