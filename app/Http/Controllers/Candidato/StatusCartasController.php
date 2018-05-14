<?php

namespace Posmat\Http\Controllers\Candidato;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\AssociaEmailsRecomendante;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\CartaMotivacao;
use Posmat\Models\ProgramaPos;
use Posmat\Models\DadoPessoal;
use Posmat\Models\Formacao;
use Posmat\Models\Estado;
use Posmat\Models\DadoAcademico;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\DadoRecomendante;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\FinalizaInscricao;
use Posmat\Models\Documento;
use Posmat\Models\Paises;
use Posmat\Models\Cidade;
use Posmat\Notifications\NotificaRecomendante;
use Posmat\Notifications\NotificaCandidato;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\RelatorioController;
use Posmat\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Posmat\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
* Classe para manipulação do candidato.
*/
class StatusCartasController extends BaseController
{

	public function getStatusCartas(){

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if (!$status_inscricao) {

				return redirect()->back();
			}

			$recomendante_candidato = new ContatoRecomendante();

			$recomendantes_candidato = $recomendante_candidato->retorna_recomendante_candidato($id_user,$id_inscricao_pos);
			
			$dados_para_template = [];

			foreach ($recomendantes_candidato as $recomendante) {

				$dado_pessoal_recomendante = new DadoRecomendante();

				$dados_para_template[$recomendante->id_recomendante]['nome_recomendante'] = $dado_pessoal_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome_recomendante;

				$carta_recomendacao = new CartaRecomendacao();
				
				$carta_aluno = $carta_recomendacao->retorna_carta_recomendacao($recomendante->id_recomendante,$id_user,$id_inscricao_pos);

				$dados_para_template[$recomendante->id_recomendante]['status_carta'] = $carta_aluno->completada;

			}
			

			return view('templates.partials.candidato.status_cartas',compact('dados_para_template'));

		}else{
			return redirect()->back();
		}
	}
}