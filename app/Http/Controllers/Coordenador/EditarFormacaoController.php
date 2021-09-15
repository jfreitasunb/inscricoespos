<?php

namespace InscricoesPos\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
* Classe para visualização da página inicial.
*/
class EditarFormacaoController extends CoordenadorController
{

	public function getEditarFormacao()
	{
		$tipo_formacao = Formacao::orderBy('id')->get()->all();

		return view('templates.partials.coordenador.editar_formacao')->with(compact('tipo_formacao'));
	}

	public function postEditarFormacao(Request $request)
	{

		$this->validate($request, [
			'id' => 'required',
			'tipo_ptbr' => 'required',
			'tipo_en' => 'required',
			'tipo_es' => 'required',
		]);



		$id = (int)$request->id;

		$dados_formacao = [
			'tipo_ptbr' => trim($request->tipo_ptbr),
			'tipo_en' => trim($request->tipo_en),
			'tipo_es' => trim($request->tipo_es),
		];

		$formacao = Formacao::find($id);

		$status_atualizacao = $formacao->update($dados_formacao);

		if ($status_atualizacao) {
			notify()->flash('Dados salvos com sucesso.','success', [
				'timer' => 2000,
			]);
		
		}else{
			notify()->flash('Ocorreu um erro. Tente novamente mais tarde.','error', [
				'timer' => 2000,
			]);
		}

		return redirect()->route('editar.formacao');

	}
}