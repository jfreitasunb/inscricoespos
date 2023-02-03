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
class PesquisaRecomendanteController extends ReativarInscricaoCandidatoController
{

	public function getPesquisarCartaEnviada()
	{

		$modo_pesquisa = true;

		return view('templates.partials.admin.reativar_carta_finalizada')->with(compact('modo_pesquisa'));
	}

	public function postPesquisarCartaEnviada(Request $request)
	{

		$this->validate($request, [
			'email_recomendante' => 'required|email',
		]);

		$email_recomendante = strtolower(trim($request->email_recomendante));

		$user = new User;

		$usuario_pesquisado = $user->retorna_user_por_email($email_recomendante);

		if ($usuario_pesquisado->user_type <> "recomendante") {
			
			notify()->flash('O e-mail informado '.$email_recomendante.' não pertence a um recomendante.','info');

			return redirect()->route('pesquisa.carta');

		}

		$id_recomendante = $this->getPesquisaCandidato($email_recomendante);

		$dados_pessoais = DadoPessoalCandidato::find($id_recomendante);

		$edital = new ConfiguraInscricaoPos;

		$edital_vigente = $edital->retorna_edital_vigente();

		$id_inscricao_pos = $edital_vigente->id_inscricao_pos;

		$cartas_recomendacoes = new CartaRecomendacao;


		$modo_pesquisa = false;

		$cartas_completadas = $cartas_recomendacoes->retorna_cartas_para_reativar($id_recomendante, $id_inscricao_pos, $this->locale_default);

		
		return view('templates.partials.admin.reativar_carta_finalizada')->with(compact('modo_pesquisa', 'cartas_completadas'));
	}

	public function postReativarCartaEnviada(Request $request)
	{
		if ($request->cancelar === 'Cancelar'){

			notify()->flash('Alteração das cartas cancelada!','info');

			return redirect()->route('pesquisa.carta');
		}

		$this->validate($request, [
			'id_inscricao_pos' => 'required',
			'id_aluno' => 'required',
			'id_recomendante' => 'required',
			'completada' => 'required',
		]);

		$id_inscricao_pos = (int)$request->id_inscricao_pos;
		$id_aluno = (int)$request->id_aluno;
		$id_recomendante = (int)$request->id_recomendante;
		$completada = (strtolower(trim($request->completada)) == 'sim' ? 1 : 0);

		$carta_recomendacao = new CartaRecomendacao;

		$carta_recomendacao->reativa_carta_finalizada($id_inscricao_pos, $id_aluno, $id_recomendante, $completada);

		notify()->flash('Alteração efetuado com sucesso','success');

		return redirect()->back();
	}
}