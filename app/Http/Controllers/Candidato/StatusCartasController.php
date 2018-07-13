<?php

namespace InscricoesPos\Http\Controllers\Candidato;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\AssociaEmailsRecomendante;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaInscricoesPos;
use InscricoesPos\Models\CartaMotivacao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DadoPessoal;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\DadoAcademico;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\DadoPessoalRecomendante;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\Documento;
use InscricoesPos\Models\Paises;
use InscricoesPos\Models\Cidade;
use InscricoesPos\Notifications\NotificaRecomendante;
use InscricoesPos\Notifications\NotificaCandidato;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\RelatorioController;
use InscricoesPos\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use InscricoesPos\Http\Requests;
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

				$dado_pessoal_recomendante = new DadoPessoalRecomendante();

				$dados_para_template[$recomendante->id_recomendante]['nome_recomendante'] = $dado_pessoal_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome;

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