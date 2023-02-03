<?php

namespace InscricoesPos\Http\Controllers\Admin;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, RelatorioController, FinalizaInscricao, ContatoRecomendante, DadoPessoalRecomendante, DadoPessoalCandidato, EscolhaCandidato, CartaRecomendacao, AssociaEmailsRecomendante};
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CoordenadorController;
use InscricoesPos\Http\Controllers\DataTable\UserController;
use InscricoesPos\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class ListaQuemIndicouController extends AdminController
{

	public function getAchaIndicacoes()
	{

		$modo_pesquisa = true;

		return view('templates.partials.admin.acha_indicacoes')->with(compact('modo_pesquisa'));
	}

	public function postAchaIndicacoes(Request $request)
	{

		$this->validate($request, [
			'email_recomendante' => 'required|email',
		]);
		
		$user = new User;
		
		$email_recomendante = trim(strtolower($request->email_recomendante));

		$recomendante = $user->retorna_user_por_email($email_recomendante);

		if (is_null($recomendante)) {
			
			notify()->flash('O e-mail: '.$email_recomendante.' não pertence a um recomendante registrado no sistema.','error');

			return redirect()->route('pesquisa.indicacoes');
		}

		$contato_recomendante = new ContatoRecomendante;

		
		if (sizeof($contato_recomendante->retorna_candidatos_por_recomendante($recomendante->id_user, $this->locale_default)) == 0) {
			
			notify()->flash('O e-mail: '.$email_recomendante.' não foi indicado por nenhum candidato no edital atual.','error');

			return redirect()->route('pesquisa.indicacoes');
		}

		$indicacoes = $contato_recomendante->retorna_candidatos_por_recomendante($recomendante->id_user, $this->locale_default);

		$modo_pesquisa = false;

		return view('templates.partials.admin.acha_indicacoes')->with(compact('modo_pesquisa', 'indicacoes'));
	}
}