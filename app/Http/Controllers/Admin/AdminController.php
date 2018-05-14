<?php

namespace Posmat\Http\Controllers\Admin;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use Posmat\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, RelatorioController, FinalizaInscricao, ContatoRecomendante, DadoRecomendante, DadoPessoal, EscolhaCandidato, CartaRecomendacao, AssociaEmailsRecomendante};
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\Coordenador\CoordenadorController;
use Posmat\Http\Controllers\DataTable\UserController;
use Posmat\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class AdminController extends CoordenadorController
{

	protected $unwanted_array = array('Š'=>'_', 'š'=>'_', 'Ž'=>'_', 'ž'=>'_', 'À'=>'_', 'Á'=>'_', 'Â'=>'_', 'Ã'=>'_', 'Ä'=>'_', 'Å'=>'_', 'Æ'=>'_', 'Ç'=>'_', 'È'=>'_', 'É'=>'_',
        'Ê'=>'_', 'Ë'=>'_', 'Ì'=>'_', 'Í'=>'_', 'Î'=>'_', 'Ï'=>'_', 'Ñ'=>'_', 'Ò'=>'_', 'Ó'=>'_', 'Ô'=>'_', 'Õ'=>'_', 'Ö'=>'_', 'Ø'=>'_', 'Ù'=>'_',
        'Ú'=>'_', 'Û'=>'_', 'Ü'=>'_', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'_', 'á'=>'_', 'â'=>'_', 'ã'=>'_', 'ä'=>'_', 'å'=>'_', 'æ'=>'_', 'ç'=>'_',
        'è'=>'_', 'é'=>'_', 'ê'=>'_', 'ë'=>'_', 'ì'=>'_', 'í'=>'_', 'î'=>'_', 'ï'=>'_', 'ð'=>'_', 'ñ'=>'_', 'ò'=>'_', 'ó'=>'_', 'ô'=>'_', 'õ'=>'_',
        'ö'=>'_', 'ø'=>'_', 'ù'=>'_', 'ú'=>'_', 'û'=>'_', 'ý'=>'_', 'þ'=>'_', 'ÿ'=>'_', 'Ğ'=>'_', 'İ'=>'_', 'Ş'=>'_', 'ğ'=>'_', 'ı'=>'_', 'ş'=>'_', 'ü'=>'_', 'ă'=>'_', 'Ă'=>'_', 'ș'=>'_', 'Ș'=>'_', 'ț'=>'_', 'Ț'=>'_');

	protected $locale_default = 'pt-br';

	protected $pesquisa = [
			'nome' => 'Nome',
			'email' => 'E-mail',
		];

	public function getMenu()
	{	
		Session::get('locale');
		return view('home');
	}
}