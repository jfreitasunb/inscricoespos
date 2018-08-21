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

        if ($relatorio->autoriza_homologacao()){
            $finalizacoes = new FinalizaInscricao;

            $inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->get();

            return view('templates.partials.coordenador.seleciona_candidatos', compact('relatorio_disponivel','inscricoes_finalizadas'));
        }else{
            notify()->flash('As inscrições não terminaram ainda. Não é possível fazer a seleção dos candidatos.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
      }
	}

    public function postSelecinarCandidatos(Request $request)
    {
        $user = Auth::user();

        $id_user = $user->id_user;

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = (int)$request->id_inscricao_pos;

        if ($relatorio->autoriza_inscricao()) {
            
            notify()->flash('As inscrições não terminaram ainda. Não é informar os candidatos selecionados.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }

        $this->validate($request, [
            'selecionar' => 'required',
        ]);

        $homologacoes = new HomologaInscricoes();

        $lista_homologacoes = $homologacoes->retorna_inscricoes_homologadas($id_inscricao_pos);

        if (sizeof($lista_homologacoes) == 0) {
            
            notify()->flash('As inscrições não foram homologadas ainda. Homologue as inscrições para poder informar os candidatos selecionados.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }

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