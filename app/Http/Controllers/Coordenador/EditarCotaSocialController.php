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
use InscricoesPos\Models\CotaSocial;
use Illuminate\Http\Request;

/**
* Classe para visualização da página inicial.
*/
class EditarCotaSocialController extends CoordenadorController
{

	public function getEditarCotaSocial()
	{
		$cota_social = CotaSocial::orderBy('id')->get()->all();

		return view('templates.partials.coordenador.editar_cota_social')->with(compact('cota_social'));
	}

	public function postEditarCotaSocial(Request $request)
	{
		$this->validate($request, [
			'id_cota_social' => 'required',
			'cota_social_ptbr' => 'required',
			'cota_social_en' => 'required',
			'cota_social_es' => 'required',
		]);

		$id_cota_social = (int)$request->id_cota_social;

		$dados_cota_social = [
			'cota_social_ptbr' => trim($request->cota_social_ptbr),
			'cota_social_en' => trim($request->cota_social_en),
			'cota_social_es' => trim($request->cota_social_es),
		];

		$cota_social = CotaSocial::find($id_cota_social);

		$status_atualizacao = $cota_social->update($dados_cota_social);

		if ($status_atualizacao) {
			notify()->flash('Dados salvos com sucesso.','success', [
				'timer' => 2000,
			]);
		
		}else{
			notify()->flash('Ocorreu um erro. Tente novamente mais tarde.','error', [
				'timer' => 2000,
			]);
		}

		return redirect()->route('editar.cota.social');

	}
}