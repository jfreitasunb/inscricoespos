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
use Posmat\Http\Controllers\CoordenadorController;
use Posmat\Http\Controllers\DataTable\UserController;
use Posmat\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class ListaTodasIndicacoesController extends AdminController
{

	public function getListaIndicacoes()
	{
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();


		$finalizacoes = new FinalizaInscricao;
		

		$inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->paginate(10);

		$dados_para_template = [];

		foreach ($inscricoes_finalizadas as $inscricao) {

			$recomendante_candidato = new ContatoRecomendante();

			$recomendantes_candidato = $recomendante_candidato->retorna_recomendante_candidato($inscricao->id_user,$inscricao->id_inscricao_pos);

			$dados_para_template[$inscricao->id_user]['nome_candidato'] = $inscricao->nome;
			$dados_para_template[$inscricao->id_user]['email'] = $inscricao->email;
			$dados_para_template[$inscricao->id_user]['tipo_programa_pos'] = $inscricao->tipo_programa_pos_ptbr;
			$i = 1;
			foreach ($recomendantes_candidato as $recomendante) {


				$dado_pessoal_recomendante = new DadoRecomendante();

				$usuario_recomendante = User::find($recomendante->id_recomendante);

				$dados_para_template[$inscricao->id_user]['email_recomendante_'.$i] = $usuario_recomendante->email;

				$dados_para_template[$inscricao->id_user]['nome_recomendante_'.$i] = $dado_pessoal_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome_recomendante;

				$carta_recomendacao = new CartaRecomendacao();
				
				$carta_aluno = $carta_recomendacao->retorna_carta_recomendacao($recomendante->id_recomendante,$inscricao->id_user,$inscricao->id_inscricao_pos);

				$dados_para_template[$inscricao->id_user]['status_carta_'.$i] = $carta_aluno->completada;

				$i++;
			}
		}
		
		return view('templates.partials.admin.tabela_indicacoes')->with(compact('dados_para_template', 'inscricoes_finalizadas'));
	}
}