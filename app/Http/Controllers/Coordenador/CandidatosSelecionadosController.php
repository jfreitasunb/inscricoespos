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
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\HomologaInscricoes;
use InscricoesPos\Models\CandidatosSelecionados;
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
class CandidatosSelecionadosController extends CoordenadorController
{

	public function getSelecinarCandidatos()
	{
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $finalizacoes = new FinalizaInscricao;

        $inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->get();

      	return view('templates.partials.coordenador.seleciona_candidatos', compact('relatorio_disponivel','inscricoes_finalizadas'));
	}

    public function postSelecinarCandidatos(Request $request)
    {
        $user = Auth::user();

        $id_user = $user->id_user;

        $this->validate($request, [
            'selecionar' => 'required',
        ]);
        
        $id_inscricao_pos = (int)$request->id_inscricao_pos;

        $limpa_homologacoes = new CandidatosSelecionados();

        $limpa_homologacoes->limpa_selecoes_anteriores($id_inscricao_pos);

        foreach ($request->selecionar as $id => $selecionar) {
            
            $homologa = new CandidatosSelecionados();

            $homologa->id_candidato = $id;

            $homologa->id_inscricao_pos = $id_inscricao_pos;

            $homologa->programa_pretendido = explode("_", $selecionar)[1];

            $homologa->selecionado = explode("_", $selecionar)[0];

            $homologa->id_coordenador = $id_user;

            $homologa->save();
        }

        notify()->flash('Dados salvos com sucesso.','success', [
            'timer' => 2000,
        ]);

        return redirect()->back();
    }
}