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
    
    $users_candidato = DB::connection('pos2')->table('inscricao_pos_login')->where('status', 'candidato')->get();

    foreach ($users_candidato as $candidato) {

      if ($candidato->coduser == 348 or $candidato->coduser == 567 or $candidato->coduser == 565 or $candidato->coduser == 566 or $candidato->coduser == 563 or $candidato->coduser == 557 or $candidato->coduser == 685 or $candidato->coduser == 632 or $candidato->coduser == 530 or $candidato->coduser == 989 or $candidato->coduser == 1339 or $candidato->coduser == 415 or $candidato->coduser == 470 or $candidato->coduser == 472 or $candidato->coduser == 2124 or $candidato->coduser == 2125 or $candidato->coduser == 667 or $candidato->coduser == 225 or $candidato->coduser == 350 or $candidato->coduser == 593 or $candidato->coduser == 1881) {
           $candidato->email = Purifier::clean(strtolower(trim($candidato->login)).'.duplicado');
         }else{
           $candidato->email = Purifier::clean(strtolower(trim($candidato->login)));
         }

         $dados_antigos_usuario = DB::connection('pos2')->table('inscricao_pos_dados_candidato')->where('id_aluno', $candidato->coduser)->first();

         
         if (!is_null($dados_antigos_usuario)) {
            $novo_usuario = new User();

            $novo_id_usuario = $novo_usuario->retorna_user_por_email($candidato->email)->id_user;

            $novos_dados_pessoais = new DadoPessoal();

            $existe_dados_pessoais = $novos_dados_pessoais->retorna_dados_pessoais($novo_id_usuario);

            if (is_null($existe_dados_pessoais)) {

                $novos_dados_pessoais->id_user = $novo_id_usuario;

                $novos_dados_pessoais->nome = trim($dados_antigos_usuario->name).' '.trim($dados_antigos_usuario->firstname);

                $novos_dados_pessoais->data_nascimento = trim($dados_antigos_usuario->anonascimento).'-'.trim($dados_antigos_usuario->mesnascimento).'-'.trim($dados_antigos_usuario->dianascimento);

                $novos_dados_pessoais->numerorg = trim($dados_antigos_usuario->identity);

                $novos_dados_pessoais->endereco = trim($dados_antigos_usuario->adresse);

                $novos_dados_pessoais->cep = trim($dados_antigos_usuario->cpendereco);

                $novos_dados_pessoais->celular = trim($dados_antigos_usuario->ddd_cel).trim($dados_antigos_usuario->telcelular);

                $novos_dados_pessoais->save();   
            }else{

                $atualiza_dados_pessoais['nome'] = trim($dados_antigos_usuario->name).' '.trim($dados_antigos_usuario->firstname);

                $atualiza_dados_pessoais['data_nascimento'] = trim($dados_antigos_usuario->anonascimento).'-'.trim($dados_antigos_usuario->mesnascimento).'-'.trim($dados_antigos_usuario->dianascimento);

                $atualiza_dados_pessoais['numerorg'] = trim($dados_antigos_usuario->identity);

                $atualiza_dados_pessoais['endereco'] = trim($dados_antigos_usuario->adresse);

                $atualiza_dados_pessoais['cep'] = trim($dados_antigos_usuario->cpendereco);

                $atualiza_dados_pessoais['celular'] = trim($dados_antigos_usuario->ddd_cel).trim($dados_antigos_usuario->telcelular);

                $existe_dados_pessoais->update($atualiza_dados_pessoais);
            }

            
         }

         
    }
    
  }
}