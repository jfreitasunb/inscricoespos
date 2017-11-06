<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use Purifier;
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
class MigracaoController extends BaseController
{
  public function getMigracao()
  {
    //Migra usuários para novo sistema

    // $users = DB::connection('pos2')->table('inscricao_pos_login')->get();

    // foreach ($users as $user) {
    //   if ($user->coduser !=197) {
    //     $novo_usuario = new User();
    //     if ($user->coduser == 348 or $user->coduser == 567 or $user->coduser == 565 or $user->coduser == 566 or $user->coduser == 563 or $user->coduser == 557 or $user->coduser == 685 or $user->coduser == 632 or $user->coduser == 530 or $user->coduser == 989 or $user->coduser == 1339 or $user->coduser == 415 or $user->coduser == 470 or $user->coduser == 472 or $user->coduser == 2124 or $user->coduser == 2125 or $user->coduser == 667 or $user->coduser == 225 or $user->coduser == 350 or $user->coduser == 593 or $user->coduser == 1881) {
    //       $novo_usuario->email = Purifier::clean(strtolower(trim($user->login)).'.duplicado');
    //     }else{
    //       $novo_usuario->email = Purifier::clean(strtolower(trim($user->login)));
    //     }
    //     $novo_usuario->password = bcrypt(trim($user->senha));
    //     $novo_usuario->validation_code = null;
    //     $novo_usuario->user_type = $user->status;
    //     $novo_usuario->ativo = true;
    //     $novo_usuario->save(); 
    //   }
    // }
    
    //Fim da migração dos usuário para o novo sistema

    //Migra dados pessoais dos candidatos para o novo sistema

    // $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->get();

    // foreach ($users_candidato as $candidato) {

    //   if ($candidato->coduser == 348 or $candidato->coduser == 567 or $candidato->coduser == 565 or $candidato->coduser == 566 or $candidato->coduser == 563 or $candidato->coduser == 557 or $candidato->coduser == 685 or $candidato->coduser == 632 or $candidato->coduser == 530 or $candidato->coduser == 989 or $candidato->coduser == 1339 or $candidato->coduser == 415 or $candidato->coduser == 470 or $candidato->coduser == 472 or $candidato->coduser == 2124 or $candidato->coduser == 2125 or $candidato->coduser == 667 or $candidato->coduser == 225 or $candidato->coduser == 350 or $candidato->coduser == 593 or $candidato->coduser == 1881) {
    //        $candidato->email = Purifier::clean(strtolower(trim($candidato->login)).'.duplicado');
    //      }else{
    //        $candidato->email = Purifier::clean(strtolower(trim($candidato->login)));
    //      }

    //     $dados_antigos_usuario = DB::connection('pos2')->table('inscricao_pos_dados_candidato')->where('id_aluno', $candidato->coduser)->first();

         
    //     if (!is_null($dados_antigos_usuario)) {
    //         $novo_usuario = new User();

    //         $novo_id_usuario = $novo_usuario->retorna_user_por_email($candidato->email)->id_user;

    //         $novos_dados_pessoais = new DadoPessoal();

    //         $existe_dados_pessoais = $novos_dados_pessoais->retorna_dados_pessoais($novo_id_usuario);

    //         if (is_null($existe_dados_pessoais)) {

    //             $novos_dados_pessoais->id_user = $novo_id_usuario;

    //             $novos_dados_pessoais->nome = trim($dados_antigos_usuario->name).' '.trim($dados_antigos_usuario->firstname);

    //             $novos_dados_pessoais->data_nascimento = trim($dados_antigos_usuario->anonascimento).'-'.trim($dados_antigos_usuario->mesnascimento).'-'.trim($dados_antigos_usuario->dianascimento);

    //             $novos_dados_pessoais->numerorg = trim($dados_antigos_usuario->identity);

    //             $novos_dados_pessoais->endereco = trim($dados_antigos_usuario->adresse);

    //             $novos_dados_pessoais->cep = trim($dados_antigos_usuario->cpendereco);

    //             $novos_dados_pessoais->celular = trim($dados_antigos_usuario->ddd_cel).trim($dados_antigos_usuario->telcelular);

    //             $novos_dados_pessoais->save();   
    //         }else{

    //             $atualiza_dados_pessoais['nome'] = trim($dados_antigos_usuario->name).' '.trim($dados_antigos_usuario->firstname);

    //             $atualiza_dados_pessoais['data_nascimento'] = trim($dados_antigos_usuario->anonascimento).'-'.trim($dados_antigos_usuario->mesnascimento).'-'.trim($dados_antigos_usuario->dianascimento);

    //             $atualiza_dados_pessoais['numerorg'] = trim($dados_antigos_usuario->identity);

    //             $atualiza_dados_pessoais['endereco'] = trim($dados_antigos_usuario->adresse);

    //             $atualiza_dados_pessoais['cep'] = trim($dados_antigos_usuario->cpendereco);

    //             $atualiza_dados_pessoais['celular'] = trim($dados_antigos_usuario->ddd_cel).trim($dados_antigos_usuario->telcelular);

    //             $existe_dados_pessoais->update($atualiza_dados_pessoais);
    //         }            
    //     }
    // }

    //Fim da Migração dos dados pessoais dos candidatos para o novo sistema
    
    //Migra os dados pessoais dos recomendantes para o novo sistema

    // $users_recomendante = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'recomendante')->get();

    // foreach ($users_recomendante as $recomendante) {

    //   if ($recomendante->coduser == 348 or $recomendante->coduser == 567 or $recomendante->coduser == 565 or $recomendante->coduser == 566 or $recomendante->coduser == 563 or $recomendante->coduser == 557 or $recomendante->coduser == 685 or $recomendante->coduser == 632 or $recomendante->coduser == 530 or $recomendante->coduser == 989 or $recomendante->coduser == 1339 or $recomendante->coduser == 415 or $recomendante->coduser == 470 or $recomendante->coduser == 472 or $recomendante->coduser == 2124 or $recomendante->coduser == 2125 or $recomendante->coduser == 667 or $recomendante->coduser == 225 or $recomendante->coduser == 350 or $recomendante->coduser == 593 or $recomendante->coduser == 1881) {
    //        $recomendante->email = Purifier::clean(strtolower(trim($recomendante->login)).'.duplicado');
    //      }else{
    //        $recomendante->email = Purifier::clean(strtolower(trim($recomendante->login)));
    //      }

    //     $dados_antigos_usuario = DB::connection('pos2')->table('inscricao_pos_dados_pessoais_recomendante')->where('id_prof', $recomendante->coduser)->first();

         
    //     if (!is_null($dados_antigos_usuario)) {
    //         $novo_usuario = new User();

    //         $novo_id_usuario = $novo_usuario->retorna_user_por_email($recomendante->email)->id_user;

    //         $novos_dados_pessoais = new DadoRecomendante();

    //         $existe_dados_pessoais = $novos_dados_pessoais->retorna_dados_pessoais_recomendante($novo_id_usuario);

    //         if (is_null($existe_dados_pessoais)) {

    //             $novos_dados_pessoais->id_prof = $novo_id_usuario;

    //             $novos_dados_pessoais->nome_recomendante = trim($dados_antigos_usuario->nomerecomendante);

    //             $novos_dados_pessoais->instituicao_recomendante = trim($dados_antigos_usuario->instituicaorecomendante);

    //             $novos_dados_pessoais->titulacao_recomendante = trim($dados_antigos_usuario->titulacaorecomendante);

    //             $novos_dados_pessoais->area_recomendante = trim($dados_antigos_usuario->arearecomendante);

    //             $novos_dados_pessoais->ano_titulacao = trim($dados_antigos_usuario->anoobtencaorecomendante);

    //             $novos_dados_pessoais->inst_obtencao_titulo = trim($dados_antigos_usuario->instobtencaorecomendante);

    //             $novos_dados_pessoais->endereco_recomendante = trim($dados_antigos_usuario->enderecorecomendante);

    //             $novos_dados_pessoais->save();   
    //         }else{

    //             $atualiza_dados_pessoais['nome_recomendante'] = trim($dados_antigos_usuario->nomerecomendante);

    //             $atualiza_dados_pessoais['instituicao_recomendante'] = trim($dados_antigos_usuario->instituicaorecomendante);;

    //             $atualiza_dados_pessoais['titulacao_recomendante'] = trim($dados_antigos_usuario->titulacaorecomendante);

    //             $atualiza_dados_pessoais['area_recomendante'] = trim($dados_antigos_usuario->arearecomendante);

    //             $atualiza_dados_pessoais['ano_titulacao'] = trim($dados_antigos_usuario->anoobtencaorecomendante);

    //             $atualiza_dados_pessoais['inst_obtencao_titulo'] = trim($dados_antigos_usuario->instobtencaorecomendante);

    //             $atualiza_dados_pessoais['endereco_recomendante'] = trim($dados_antigos_usuario->enderecorecomendante);

    //             $existe_dados_pessoais->update($atualiza_dados_pessoais);
    //         }            
    //     }
    // }

    //Fim da migração dos dados pessoais do candidato para o novo sistema

    //Migra dados acadêmicos dos candidatos para o novo sistema.

    $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->get();

    foreach ($users_candidato as $candidato) {

        $dados_academicos_antigos_usuario = DB::connection('pos2')->table('inscricao_pos_dados_profissionais_candidato')->where('id_aluno', $candidato->coduser)->first();

         
        if (!is_null($dados_academicos_antigos_usuario)) {
            
            $novo_usuario = new User();

            $novo_id_usuario = $novo_usuario->retorna_dados_academicos($candidato->email)->id_user;

            $novos_dados_academicos = new DadoAcademico();

            $existe_dados_academicos = $novos_dados_academicos->retorna_dados_pessoais($novo_id_usuario);

            if (is_null($existe_dados_academicos)) {

                $novos_dados_academicos->id_user = $novo_id_usuario;

                if ($dados_antigos_usuario->instrucaograu == 'bacharel') {
                    
                    $novos_dados_academicos->tipo_curso_graduacao = 1;

                    $novos_dados_academicos->curso_graduacao = trim($dados_antigos_usuario->instrucaocurso);

                    $novos_dados_academicos->instituicao_graduacao = trim($dados_antigos_usuario->instrucaoinstituicao);

                    $novos_dados_academicos->ano_conclusao_graduacao = trim($dados_antigos_usuario->instrucaoanoconclusao);
                }

                if ($dados_antigos_usuario->instrucaograu == 'licenciado') {
                    
                    $novos_dados_academicos->tipo_curso_graduacao = 2;

                    $novos_dados_academicos->curso_graduacao = trim($dados_antigos_usuario->instrucaocurso);

                    $novos_dados_academicos->instituicao_graduacao = trim($dados_antigos_usuario->instrucaoinstituicao);

                    $novos_dados_academicos->ano_conclusao_graduacao = trim($dados_antigos_usuario->instrucaoanoconclusao);
                }

                if ($dados_antigos_usuario->instrucaograu == 'outro') {
                    
                    $novos_dados_academicos->tipo_curso_graduacao = 7;   
                }

                if ($dados_antigos_usuario->instrucaograu == 'mestre' or $dados_antigos_usuario->instrucaograu == 'especialista') {
                    
                    $novos_dados_academicos->tipo_curso_pos = 5;
                    $novos_dados_academicos->curso_pos = trim($dados_antigos_usuario->instrucaocurso);

                    $novos_dados_academicos->instituicao_pos = trim($dados_antigos_usuario->instrucaoinstituicao);

                    $novos_dados_academicos->ano_conclusao_pos = trim($dados_antigos_usuario->instrucaoanoconclusao);
                }

                if ($dados_antigos_usuario->instrucaograu == 'outro') {
                    
                    $novos_dados_academicos->tipo_curso_pos = 8;   
                }

                $novos_dados_academicos->save();

            }else{

                if ($dados_antigos_usuario->instrucaograu == 'bacharel') {
                    
                    $atualiza_dados_pessoais['tipo_curso_graduacao'] = 1;

                    $atualiza_dados_pessoais['curso_graduacao'] = trim($dados_antigos_usuario->instrucaocurso);

                    $atualiza_dados_pessoais['instituicao_graduacao'] = trim($dados_antigos_usuario->instrucaoinstituicao);

                    $atualiza_dados_pessoais['ano_conclusao_graduacao'] = trim($dados_antigos_usuario->instrucaoanoconclusao);
                }

                if ($dados_antigos_usuario->instrucaograu == 'licenciado') {
                    
                    $atualiza_dados_pessoais['tipo_curso_graduacao'] = 2;

                    $atualiza_dados_pessoais['curso_graduacao'] = trim($dados_antigos_usuario->instrucaocurso);

                    $atualiza_dados_pessoais['instituicao_graduacao'] = trim($dados_antigos_usuario->instrucaoinstituicao);

                    $atualiza_dados_pessoais['ano_conclusao_graduacao'] = trim($dados_antigos_usuario->instrucaoanoconclusao);
                }

                if ($dados_antigos_usuario->instrucaograu == 'outro') {
                    
                    $atualiza_dados_pessoais['tipo_curso_graduacao'] = 7;   
                }

                if ($dados_antigos_usuario->instrucaograu == 'mestre' or $dados_antigos_usuario->instrucaograu == 'especialista') {
                    
                    $atualiza_dados_pessoais['tipo_curso_pos'] = 5;
                    $atualiza_dados_pessoais['curso_pos'] = trim($dados_antigos_usuario->instrucaocurso);

                    $atualiza_dados_pessoais['instituicao_pos'] = trim($dados_antigos_usuario->instrucaoinstituicao);

                    $atualiza_dados_pessoais['ano_conclusao_pos'] = trim($dados_antigos_usuario->instrucaoanoconclusao);
                }

                if ($dados_antigos_usuario->instrucaograu == 'outro') {
                    
                    $atualiza_dados_pessoais['tipo_curso_pos'] = 8;   
                }

                $existe_dados_academicos->update($atualiza_dados_pessoais);
            }            
        }
    }

    //Fim da migração dos dados acadêmicos dos candidatos para o novo sistema.


  }
}