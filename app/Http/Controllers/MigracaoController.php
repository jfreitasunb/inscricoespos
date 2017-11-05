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
    $users = DB::connection('pos2')->table('inscricao_pos_login')->get();

    foreach ($users as $user) {
      if ($user->coduser !=197) {
        $novo_usuario = new User();
        if ($user->coduser == 348 or $user->coduser == 567 or $user->coduser == 565 or $user->coduser == 566 or $user->coduser == 563 or $user->coduser == 557 or $user->coduser == 685 or $user->coduser == 632 or $user->coduser == 530 or $user->coduser == 989 or $user->coduser == 1339 or $user->coduser == 415 or $user->coduser == 470 or $user->coduser == 472 or $user->coduser == 2124 or $user->coduser == 2125 or $user->coduser == 667 or $user->coduser == 225 or $user->coduser == 350 or $user->coduser == 593 or $user->coduser == 1881) {
          $novo_usuario->email = Purifier::clean(strtolower(trim($user->login)).'.duplicado');
        }else{
          $novo_usuario->email = Purifier::clean(strtolower(trim($user->login)));
        }
        $novo_usuario->password = bcrypt(trim($user->senha));
        $novo_usuario->validation_code = null;
        $novo_usuario->user_type = $user->status;
        $novo_usuario->ativo = true;
        $novo_usuario->save(); 
      }
    }
    dd($users);
  }
}