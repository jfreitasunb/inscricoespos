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
class EditarPeriodoConfirmacaoController extends AdminController
{

	public function getEditarPeriodoConfirmacao()
	{

		$edital = new ConfiguraInscricaoPos();

      	$id_inscricao_pos = $edital->retorna_edital_vigente()->id_inscricao_pos;

      	$configura_inicio = new ConfiguraInicioPrograma();
      	
      	if (sizeof($configura_inicio->retorna_meses_para_inicio($id_inscricao_pos)) == 0) {
      		notify()->flash('Período de confirmação não configurado ainda!','warning', ['timer' => 3000,]);

			return redirect()->route('home');
      	}else{
      		
      		$periodo_confirmacao = $configura_inicio->retorna_meses_para_inicio($id_inscricao_pos);

      		return view('templates.partials.admin.editar_periodo_confirmacao')->with(compact('periodo_confirmacao', 'id_inscricao_pos'));
      	}
	}

	public function postEditarPeriodoConfirmacao(Request $request)
	{
		$configura_inicio = new ConfiguraInicioPrograma();

		$periodos_existentes = $configura_inicio->retorna_meses_para_inicio($request->id_inscricao_pos);

		foreach ($periodos_existentes as $existe) {
			
			$periodo_existente = ConfiguraInicioPrograma::find($existe->id_inicio_programa);

			$novo_periodio_confirmacao['mes_inicio'] = $request->{'mes_inicio_inscricao_'.$existe->id_inicio_programa};
			
			$novo_periodio_confirmacao['prazo_confirmacao'] = $request->{'fim_confirmacao_'.$existe->id_inicio_programa};
			
			$novo_periodio_confirmacao['programa_para_confirmar'] = $request->{'programa_para_confirmar_'.$existe->id_inicio_programa};
			
			$periodo_existente->update($novo_periodio_confirmacao);
		}

		notify()->flash('Período de confirmação alterado com sucesso!','success', ['timer' => 3000,]);

		return redirect()->route('editar.periodo.confirmacao');
	}
}