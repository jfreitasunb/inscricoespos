<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use Posmat\Models\User;
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
use Posmat\Notifications\NotificaRecomendante;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Posmat\Http\Requests;
use Illuminate\Support\Facades\Response;

/**
* Classe para manipulação do recomendante.
*/
class RecomendanteController extends BaseController
{

/*
/Gravação dos dados Pessoais
 */

	public function getDadosPessoaisRecomendante()
	{

		$user = Auth::user();
		$id_user = $user->id_user;
		
		$recomendante = new DadoRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($status_dados_pessoais) {
			
			notify()->flash(trans('tela_recomendante_dados_pessoais.atualizar_dados'),'info');

			$dados = $recomendante->retorna_dados_pessoais_recomendante($id_user);

			return view('templates.partials.recomendante.dados_pessoais')->with(compact('countries','dados'));
		}else{

			if ($autoriza_carta) {
				return redirect()->route('cartas.pendentes');	
			}else{

				return redirect()->back();
			}
			
		}
		
		
	}

	
}