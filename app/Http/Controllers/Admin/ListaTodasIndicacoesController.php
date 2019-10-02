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
class ListaTodasIndicacoesController extends AdminController
{

	public function getListaIndicacoes()
	{
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();

      	$edital_vigente = explode("-",$relatorio_disponivel->edital)[1]."/".explode("-",$relatorio_disponivel->edital)[0];


		$finalizacoes = new FinalizaInscricao;

		$inscricoes_finalizadas = $finalizacoes->retorna_usuarios_lista_indicacoes($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->paginate(10);

		$dados_para_template = [];

		foreach ($inscricoes_finalizadas as $inscricao) {

			$recomendante_candidato = new ContatoRecomendante();

			$recomendantes_candidato = $recomendante_candidato->retorna_recomendante_candidato($inscricao->id_candidato,$inscricao->id_inscricao_pos);

			$dados_para_template[$inscricao->id_candidato]['nome_candidato'] = $inscricao->nome;
			$dados_para_template[$inscricao->id_candidato]['email'] = $inscricao->email;
			$dados_para_template[$inscricao->id_candidato]['tipo_programa_pos'] = $inscricao->tipo_programa_pos_ptbr;
			$i = 1;
			foreach ($recomendantes_candidato as $recomendante) {

				$usuario_recomendante = User::find($recomendante->id_recomendante);

				$dados_para_template[$inscricao->id_candidato]['email_recomendante_'.$i] = $usuario_recomendante->email;

				$dados_para_template[$inscricao->id_candidato]['nome_recomendante_'.$i] = $usuario_recomendante->nome;

				$carta_recomendacao = new CartaRecomendacao();
				
				$carta_aluno = $carta_recomendacao->retorna_carta_recomendacao($recomendante->id_recomendante,$inscricao->id_candidato,$inscricao->id_inscricao_pos);

				$dados_para_template[$inscricao->id_candidato]['status_carta_'.$i] = $carta_aluno->completada;

				$i++;
			}
		}

		$totaliza = new CartaRecomendacao();

		$total_cartas_recebidas = $totaliza->conta_total_cartas_por_edital_situacao($relatorio_disponivel->id_inscricao_pos, true);

		$total_cartas_solicitas = $totaliza->conta_total_cartas_por_edital_situacao($relatorio_disponivel->id_inscricao_pos, false);
		
		return view('templates.partials.admin.tabela_indicacoes')->with(compact('dados_para_template', 'inscricoes_finalizadas', 'edital_vigente', 'total_cartas_solicitas', 'total_cartas_recebidas'));
	}
}