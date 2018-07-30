<?php

namespace InscricoesPos\Http\Controllers\Recomendante;

use Auth;
use DB;
use Mail;
use Session;
use PDF;
use File;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaMotivacao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DadoPessoalCandidato;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\DadoAcademico;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\DadoPessoalRecomendante;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\Documento;
use InscricoesPos\Notifications\NotificaRecomendante;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use InscricoesPos\Http\Requests;
use Illuminate\Support\Facades\Response;

/**
* Classe para manipulação do recomendante.
*/
class CartasPendentesController extends RecomendanteController
{

	public function getCartasPendentes()
	{

		$user = $this->SetUser();

		$id_user = $user->id_user;
		
		$locale_recomendante = Session::get('locale');

		$recomendante = new DadoPessoalRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($autoriza_carta) {
			
			$recomendante_indicado = new ContatoRecomendante();

			$indicacoes = $recomendante_indicado->retorna_indicacoes($id_user,$id_inscricao_pos);

			if (count($indicacoes)>0) {
				foreach ($indicacoes as $indicado) {
				
					$indicador = new DadoPessoalCandidato();

					$programa = new EscolhaCandidato();

					$programa_pretendido_candidato = $programa->retorna_escolha_candidato($indicado->id_candidato,$id_inscricao_pos);


					$nome_programa_pos = new ProgramaPos();

					$dados_indicador = $indicador->retorna_dados_pessoais($indicado->id_candidato);

					$dados_para_template[$indicado->id_candidato]['id_candidato'] = $indicado->id_candidato;

					$dados_para_template[$indicado->id_candidato]['nome_candidato'] = $dados_indicador->nome;
					$dados_para_template[$indicado->id_candidato]['programa_pretendido'] = $nome_programa_pos->pega_programa_pos_mat($programa_pretendido_candidato->programa_pretendido, $locale_recomendante);

					$dados_cartas = new CartaRecomendacao();

					$carta_aluno = $dados_cartas->retorna_carta_recomendacao($id_user,$indicado->id_candidato,$id_inscricao_pos);

					$dados_para_template[$indicado->id_candidato]['status_carta'] = $carta_aluno->completada;

					$sem_carta = false;

				}
			}else{
				$sem_carta = true;
			}
			

			return view('templates.partials.recomendante.cartas_pendentes',compact('dados_para_template','sem_carta'));

		}else{

			notify()->flash(trans('tela_cartas_pendentes.prazo_carta'), 'info');

			return redirect()->back();
		}
	}

}