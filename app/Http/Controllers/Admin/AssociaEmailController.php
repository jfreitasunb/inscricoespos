<?php

namespace InscricoesPos\Http\Controllers\Admin;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, RelatorioController, FinalizaInscricao, ContatoRecomendante, DadoRecomendante, DadoPessoal, EscolhaCandidato, CartaRecomendacao, AssociaEmailsRecomendante};
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
class AssociaEmailController extends AdminController
{

	public function getAssociaEmail()
	{
		return view('templates.partials.admin.associa_email_recomendante');
	}

	public function postAssociaEmail(Request $request)
	{
		$this->validate($request, [
			'email_informado' => 'required|email',
			'email_preferido' => 'required|email',
		]);

		$email_informado = strtolower(trim($request->email_informado));

		$email_preferido = strtolower(trim($request->email_preferido));

		$associa_email = new AssociaEmailsRecomendante;

		$associacao_previa = $associa_email->retorna_associacao($email_informado);

		if (!is_null($associacao_previa)) {
			
			notify()->flash('O e-mail: '.$email_informado.' já está associado com o endereço: '.$associacao_previa, 'error');

			return redirect()->route('associa.recomendantes');
		}

		$associa_email->email_fornecido = $email_informado;

		$associa_email->email_preferido = $email_preferido;

		$status_associacao = $associa_email->save();

		if ($status_associacao) {
			notify()->flash('Associação criada com sucesso', 'success', ['timer' => 1500,]);

			return redirect()->route('associa.recomendantes');
		}
	}
}