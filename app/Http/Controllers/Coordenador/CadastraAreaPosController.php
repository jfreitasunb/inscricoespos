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
class CadastraAreaPosController extends CoordenadorController
{

	public function getCadastraAreaPos()
	{
		return view('templates.partials.coordenador.cadastra_area_pos');
	}


	public function postCadastraAreaPos(Request $request)
	{
		$this->validate($request, [
			'nome_ptbr' => 'required',
			'nome_en' => 'required',
			'nome_es' => 'required',
		]);

		$nova_area_pos = new AreaPosMat;

		$nova_area_pos->nome_ptbr = trim($request->nome_ptbr);
		$nova_area_pos->nome_en = trim($request->nome_en);
		$nova_area_pos->nome_es = trim($request->nome_es);
		$status_gravacao = $nova_area_pos->save();

		if ($status_gravacao) {
			notify()->flash('Dados salvos com sucesso.','success', [
				'timer' => 2000,
			]);
		
		}else{
			notify()->flash('Ocorreu um erro. Tente novamente mais tarde.','error', [
				'timer' => 2000,
			]);
		}

		return redirect()->route('cadastra.area.pos');
	}
}