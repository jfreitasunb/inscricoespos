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
class DadosPessoaisRecomendanteController extends RecomendanteController
{

	/*
/Gravação dos dados Pessoais
 */

	public function getDadosPessoaisRecomendante()
	{

		$user = $this->SetUser();

		$id_user = $user->id_user;
		
		$recomendante = new DadoPessoalRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$dados = $recomendante->retorna_dados_pessoais_recomendante($id_user);

		$editar_dados = false;

		return view('templates.partials.recomendante.dados_pessoais')->with(compact('countries','dados', 'editar_dados'));
		
	}

	public function getDadosPessoaisRecomendanteEditar()
	{

		$user = $this->SetUser();

		$id_user = $user->id_user;
		
		$recomendante = new DadoPessoalRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$dados = $recomendante->retorna_dados_pessoais_recomendante($id_user);

		$editar_dados = true;

		return view('templates.partials.recomendante.dados_pessoais')->with(compact('countries','dados', 'editar_dados'));
		
	}

	public function postDadosPessoaisRecomendante(Request $request)
	{
		$this->validate($request, [
			'nome' => 'required',
			'instituicao_recomendante' => 'required',
			'titulacao_recomendante' => 'required',
			'area_recomendante' => 'required',
			'ano_titulacao' => 'required',
			'inst_obtencao_titulo' => 'required',
			'endereco_recomendante' => 'required',
		]);

		$user = $this->SetUser();

		$id_user = $user->id_user;

		$user_recomendante = User::find($id_user);

		$atualiza_nome['nome'] = Purifier::clean(trim($request->input('nome')));

		$user_recomendante->update($atualiza_nome);
		
		$recomendante = new DadoPessoalRecomendante();

		$id_recomendante = $recomendante->select('id')->where('id_recomendante', $id_user)->pluck('id');

		$atualiza_dados_recomendantes['instituicao_recomendante'] = Purifier::clean(trim($request->input('instituicao_recomendante')));
		$atualiza_dados_recomendantes['titulacao_recomendante'] = Purifier::clean(trim($request->input('titulacao_recomendante')));
		$atualiza_dados_recomendantes['area_recomendante'] = Purifier::clean(trim($request->input('area_recomendante')));
		$atualiza_dados_recomendantes['ano_titulacao'] = Purifier::clean(trim($request->input('ano_titulacao')));
		$atualiza_dados_recomendantes['inst_obtencao_titulo'] = Purifier::clean(trim($request->input('inst_obtencao_titulo')));
		$atualiza_dados_recomendantes['endereco_recomendante'] = Purifier::clean(trim($request->input('endereco_recomendante')));
		$atualiza_dados_recomendantes['atualizado'] = 1;
		$atualiza_dados_recomendantes['updated_at'] = date('Y-m-d H:i:s');

		DB::table('dados_pessoais_recomendantes')->where('id', $id_recomendante[0])->where('id_recomendante', $id_user)->update($atualiza_dados_recomendantes);



		return redirect()->route('cartas.pendentes');
	}

}