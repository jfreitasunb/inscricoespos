<?php

namespace Posmat\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\Formacao;
use Posmat\Models\ProgramaPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
* Classe para visualização da página inicial.
*/
class EditarAreaPosController extends CoordenadorController
{

	public function getEditarAreaPos()
	{
		$areas_pos_mat = AreaPosMat::orderBy('id_area_pos')->get()->all();

		return view('templates.partials.coordenador.editar_area_pos')->with(compact('areas_pos_mat'));
	}

	public function postEditarAreaPos(Request $request)
	{
		$this->validate($request, [
			'id_area_pos' => 'required',
			'nome_ptbr' => 'required',
			'nome_en' => 'required',
			'nome_es' => 'required',
		]);

		$id_area_pos = (int)$request->id_area_pos;

		$dados_area_pos = [
			'nome_ptbr' => trim($request->nome_ptbr),
			'nome_en' => trim($request->nome_en),
			'nome_es' => trim($request->nome_es),
		];

		$area_pos = AreaPosMat::find($id_area_pos);

		$status_atualizacao = $area_pos->update($dados_area_pos);

		if ($status_atualizacao) {
			notify()->flash('Dados salvos com sucesso.','success', [
				'timer' => 2000,
			]);
		
		}else{
			notify()->flash('Ocorreu um erro. Tente novamente mais tarde.','error', [
				'timer' => 2000,
			]);
		}

		return redirect()->route('editar.area.pos');

	}
}