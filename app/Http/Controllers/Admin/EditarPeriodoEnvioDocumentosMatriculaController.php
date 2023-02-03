<?php

namespace InscricoesPos\Http\Controllers\Admin;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, ConfiguraEnvioDocumentosMatricula};
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

      	$id_inscricao_pos = $edital->retorna_edital_vigente()->id_inscricao_pos;

      	$envio_documentos = new ConfiguraEnvioDocumentosMatricula();
      	
      	$perido_envio_documentos = $envio_documentos->retorna_periodo_envio_documentos_matricula($id_inscricao_pos);

      	return view('templates.partials.admin.editar_periodo_envio_documentos_matricula')->with(compact('perido_envio_documentos', 'id_inscricao_pos'));
	}

	public function postEditarPeriodoEnvioDocumentosMatricula(Request $request)
	{

		$id_inscricao_pos = $request->id_inscricao_pos;

		$configura_inicio = new ConfiguraEnvioDocumentosMatricula();

		$periodos_existentes = $configura_inicio->retorna_periodo_envio_documentos_matricula($id_inscricao_pos);

		foreach ($periodos_existentes as $existe) {
			
			$periodo_existente = ConfiguraEnvioDocumentosMatricula::find($existe->id);

			$prazo_inicio_envio_documentos = Carbon::createFromFormat('Y-m-d', $request->{'inicio_envio_documentos_'.$existe->id});

			$prazo_fim_envio_documentos = Carbon::createFromFormat('Y-m-d', $request->{'fim_envio_documentos_'.$existe->id});

			if ($prazo_inicio_envio_documentos > $prazo_fim_envio_documentos) {
				
				notify()->flash('O prazo de início de envio dos documentos deve ser inferior à data: '.$prazo_fim_envio_documentos->format('Y-m-d'),'error');

				return redirect()->route('editar.periodo.envio.documentos.matricula');
			}
			
			$novo_periodo_envio['inicio_envio_documentos'] = $request->{'inicio_envio_documentos_'.$existe->id};
			
			$novo_periodo_envio['fim_envio_documentos'] = $request->{'fim_envio_documentos_'.$existe->id};
			
			$periodo_existente->update($novo_periodo_envio);
		}

		notify()->flash('Inscrição alterada com sucesso!','success', ['timer' => 3000,]);

		return redirect()->route('editar.periodo.envio.documentos.matricula');
	}
}