<?php

namespace Posmat\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\Formacao;
use Posmat\Models\ProgramaPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
* Classe para visualização da página inicial.
*/
class CoordenadorController extends BaseController
{

	public $locale_default = 'pt-br';

	public function getMenu()
	{	
		return view('home');
	}
}