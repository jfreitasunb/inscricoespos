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

	public function getConfiguraPeriodoMatricula(Request $request)
	{
        $user = Auth::user();

        $id_coordenador = $user->id_user;

		$this->validate($request, [
			'mes_inicio_1' => 'required',
			'prazo_confirmacao_mes_1' => 'required|date_format:"d/m/Y"|after:today',
		]);

        $id_inscricao_pos = (int)$request->id_inscricao_pos;

        $mes_inicio_1 = (int)$request->mes_inicio_1;

        $prazo_confirmacao_mes_1 = Carbon::createFromFormat('d/m/Y', $request->prazo_confirmacao_mes_1);

        $edital_vigente = ConfiguraInscricaoPos::find($id_inscricao_pos);

        $configura_inicio = new ConfiguraInicioPrograma();

        $configura_inicio->limpa_configuracoes_anteriores($id_inscricao_pos);

        $configura_inicio->id_inscricao_pos = $id_inscricao_pos;

        $configura_inicio->mes_inicio = $mes_inicio_1;

        $configura_inicio->prazo_confirmacao = $prazo_confirmacao_mes_1;

        $configura_inicio->id_coordenador = $id_coordenador;

        $configura_inicio->save();

        if (!is_null($request->mes_inicio_2)) {
            $this->validate($request, [
                'mes_inicio_2' => 'required|date_format:"m"|after:mes_inicio_1',
                'prazo_confirmacao_mes_2' => 'required|date_format:"d/m/Y"|after:prazo_confirmacao_mes_1',
            ]);

            $prazo_confirmacao_mes_2 = Carbon::createFromFormat('d/m/Y', $request->prazo_confirmacao_mes_2);

            $mes_inicio_2 = (int)$request->mes_inicio_2;

            $edital_vigente = ConfiguraInscricaoPos::find($id_inscricao_pos);

            $configura_inicio = new ConfiguraInicioPrograma();

            $configura_inicio->id_inscricao_pos = $id_inscricao_pos;

            $configura_inicio->mes_inicio = $mes_inicio_2;

            $configura_inicio->prazo_confirmacao = $prazo_confirmacao_mes_2;

            $configura_inicio->id_coordenador = $id_coordenador;

            $configura_inicio->save();
        }

        notify()->flash('Período de confirmação configurado com sucesso!','success', ['timer' => 3000,]);

        return redirect()->route('home');
	}
}