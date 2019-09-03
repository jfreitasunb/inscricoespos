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
use InscricoesPos\Models\ConfiguraInicioPrograma;
use InscricoesPos\Models\ConfiguraEnvioDocumentosMatricula;
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
class ConfiguraPeriodoEnvioDocumentosMatriculaController extends CoordenadorController
{

	public function getConfiguraPeriodoMatricula()
	{

		$edital = new ConfiguraInscricaoPos();

        $edital_vigente = $edital->retorna_edital_vigente();

        $edital = str_pad(explode('-', $edital_vigente->edital)[1], 2, '0', STR_PAD_LEFT)."/".explode('-', $edital_vigente->edital)[0];

		return view('templates.partials.coordenador.configurar_periodo_envio_documentos_matricula')->with(compact('edital', 'edital_vigente'));
	}

	public function postConfiguraPeriodoMatricula(Request $request)
	{
        $user = Auth::user();

        $id_coordenador = $user->id_user;

		$this->validate($request, [
			'inicio_entrega' => 'required',
			'fim_entrega' => 'required|date_format:"d/m/Y"|after:today',
		]);

        $id_inscricao_pos = (int)$request->id_inscricao_pos;

        $inicio_entrega = Carbon::createFromFormat('d/m/Y', $request->inicio_entrega);

        $fim_entrega = Carbon::createFromFormat('d/m/Y', $request->fim_entrega);

        $edital_vigente = ConfiguraInscricaoPos::find($id_inscricao_pos);

        $configura_envio_documentos = new ConfiguraEnvioDocumentosMatricula();

        $configura_envio_documentos->id_inscricao_pos = $id_inscricao_pos;

        $configura_envio_documentos->inicio_envio_documentos = $inicio_entrega;

        $configura_envio_documentos->fim_envio_documentos = $fim_entrega;

        $configura_envio_documentos->id_coordenador = $id_coordenador;

        $configura_envio_documentos->save();

        notify()->flash('Período de confirmação configurado com sucesso!','success', ['timer' => 3000,]);

        return redirect()->route('home');
	}
}