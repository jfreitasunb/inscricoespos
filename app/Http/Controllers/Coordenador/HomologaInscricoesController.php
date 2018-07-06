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
use Posmat\Models\HomologaInscricoes;
use Posmat\Models\ProgramaPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\RelatorioController;
use Illuminate\Foundation\Auth\RegistersUsers;
use UrlSigner;
use URL;

/**
* Classe para visualização da página inicial.
*/
class HomologaInscricoesController extends CoordenadorController
{

	public function getHomologarInscritos()
	{
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $finalizacoes = new FinalizaInscricao;

        $inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->get();

      	return view('templates.partials.coordenador.homologa_inscricoes', compact('relatorio_disponivel','inscricoes_finalizadas'));
	}

    public function postHomologarInscritos(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'homologar' => 'required',
        ]);

        foreach ($request->homologar as $homologando) {
            
            $homologa = new HomologaInscricoes();

            $homologa->id_candidato = explode("_", $homologando)[0];

            $homologa->id_inscricao_pos = (int)$request->id_inscricao_pos;

            $homologa->programa_pretendido = explode("_", $homologando)[1];
        }


    }
}