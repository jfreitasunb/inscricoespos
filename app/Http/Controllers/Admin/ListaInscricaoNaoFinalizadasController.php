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
class ListaInscricaoNaoFinalizadasController extends AdminController
{

	public function getInscricoesNaoFinalizadas()
	{
		// $relatorio = new ConfiguraInscricaoPos();

  //     	$relatorio_disponivel = $relatorio->retorna_edital_vigente();

		// $tipo_programa_pos = new FinalizaInscricao;

		// $inscricoes_nao_finalizadas = $tipo_programa_pos->usuarios_nao_finalizados($relatorio_disponivel->id_inscricao_pos)->paginate(10);

		return view('templates.partials.admin.nao_finalizadas');
	}
}