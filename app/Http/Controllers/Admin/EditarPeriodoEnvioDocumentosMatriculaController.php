<?php

namespace InscricoesPos\Http\Controllers\Admin;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, ConfiguraInicioPrograma};
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CoordenadorController;
use InscricoesPos\Http\Controllers\DataTable\UserController;
use InscricoesPos\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class EditarPeriodoEnvioDocumentosMatriculaController extends AdminController
{

	public function getEditarPeriodoEnvioDocumentosMatricula()
	{

		$edital = new ConfiguraInscricaoPos();

      	$edital_vigente = $edital->retorna_edital_vigente();

      	return view('templates.partials.admin.editar_periodo_envio_documentos_matricula')->with(compact('edital_vigente'));
	}

	public function postEditarPeriodoEnvioDocumentosMatricula(Request $request)
	{

		$this->validate($request, [
			'inicio_inscricao' => 'required|date_format:"Y-m-d"|before:fim_inscricao',
			'fim_inscricao' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
			'prazo_carta' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
			'data_homologacao' => 'required|date_format:"Y-m-d"|after:fim_inscricao',
			'data_divulgacao_resultado' => 'required|date_format:"Y-m-d"|after:data_homologacao',
			'edital' => 'required',
			'programa' => 'required',
		]);

		$edital_vigente = ConfiguraInscricaoPos::find((int)$request->id_inscricao_pos);

		$novos_dados_edital['inicio_inscricao'] = $request->inicio_inscricao;
		$novos_dados_edital['fim_inscricao'] = $request->fim_inscricao;
		$novos_dados_edital['prazo_carta'] = $request->prazo_carta;
		$novos_dados_edital['programa'] = $request->programa;
		$novos_dados_edital['edital'] = $request->edital;
		$novos_dados_edital['data_homologacao'] = $request->data_homologacao;
		$novos_dados_edital['data_divulgacao_resultado'] = $request->data_divulgacao_resultado;

		$edital_vigente->update($novos_dados_edital);

		notify()->flash('Inscrição alterada com sucesso!','success', ['timer' => 3000,]);

		return redirect()->route('editar.periodo.envio.documentos.matricula');
	}
}