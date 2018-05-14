<?php

namespace Posmat\Http\Controllers\Recomendante;

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
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Posmat\Http\Requests;
use Illuminate\Support\Facades\Response;

/**
* Classe para manipulação do recomendante.
*/
class DadosPessoaisRecomendanteController extends RecomendanteController
{

	/*
/Gravação dos dados Pessoais
 */

	public function getDadosPessoaisRecomendante()
	{

		$user = $this->SetUser();

		$id_user = $user->id_user;
		
		$recomendante = new DadoRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$dados = $recomendante->retorna_dados_pessoais_recomendante($id_user);

		$editar_dados = false;

		return view('templates.partials.recomendante.dados_pessoais')->with(compact('countries','dados', 'editar_dados'));
		
	}

	public function getDadosPessoaisRecomendanteEditar()
	{

		$user = $this->SetUser();

		$id_user = $user->id_user;
		
		$recomendante = new DadoRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$dados = $recomendante->retorna_dados_pessoais_recomendante($id_user);

		$editar_dados = true;

		return view('templates.partials.recomendante.dados_pessoais')->with(compact('countries','dados', 'editar_dados'));
		
	}

	public function postDadosPessoaisRecomendante(Request $request)
	{
		$this->validate($request, [
			'nome_recomendante' => 'required',
			'instituicao_recomendante' => 'required',
			'titulacao_recomendante' => 'required',
			'area_recomendante' => 'required',
			'ano_titulacao' => 'required',
			'inst_obtencao_titulo' => 'required',
			'endereco_recomendante' => 'required',
		]);

		$user = $this->SetUser();

		$id_user = $user->id_user;
		
		$recomendante = new DadoRecomendante();

		$id_recomendante = $recomendante->select('id')->where('id_prof', $id_user)->pluck('id');

		$atualiza_dados_recomendantes['nome_recomendante'] = Purifier::clean(trim($request->input('nome_recomendante')));
		$atualiza_dados_recomendantes['instituicao_recomendante'] = Purifier::clean(trim($request->input('instituicao_recomendante')));
		$atualiza_dados_recomendantes['titulacao_recomendante'] = Purifier::clean(trim($request->input('titulacao_recomendante')));
		$atualiza_dados_recomendantes['area_recomendante'] = Purifier::clean(trim($request->input('area_recomendante')));
		$atualiza_dados_recomendantes['ano_titulacao'] = Purifier::clean(trim($request->input('ano_titulacao')));
		$atualiza_dados_recomendantes['inst_obtencao_titulo'] = Purifier::clean(trim($request->input('inst_obtencao_titulo')));
		$atualiza_dados_recomendantes['endereco_recomendante'] = Purifier::clean(trim($request->input('endereco_recomendante')));
		$atualiza_dados_recomendantes['atualizado'] = 1;
		$atualiza_dados_recomendantes['updated_at'] = date('Y-m-d H:i:s');

		DB::table('dados_recomendantes')->where('id', $id_recomendante[0])->where('id_prof', $id_user)->update($atualiza_dados_recomendantes);



		return redirect()->route('cartas.pendentes');
	}

}