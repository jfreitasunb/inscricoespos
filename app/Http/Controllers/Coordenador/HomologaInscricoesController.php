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
use InscricoesPos\Models\AreaInscricoesPos;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\HomologaInscricoes;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\RelatorioController;
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

        $id_user = $user->id_user;

        $this->validate($request, [
            'homologar' => 'required',
        ]);
        
        $id_inscricao_pos = (int)$request->id_inscricao_pos;

        $limpa_homologacoes = new HomologaInscricoes();

        $limpa_homologacoes->limpa_homologacoes_anteriores($id_inscricao_pos);

        foreach ($request->homologar as $id => $homologar) {
            
            $homologa = new HomologaInscricoes();

            $homologa->id_candidato = $id;

            $homologa->id_inscricao_pos = $id_inscricao_pos;

            $homologa->programa_pretendido = explode("_", $homologar)[1];

            $homologa->homologar = explode("_", $homologar)[0];

            $homologa->id_coordenador = $id_user;

            $homologa->save();
        }


    }
}