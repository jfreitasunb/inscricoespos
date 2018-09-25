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

        if ($relatorio->autoriza_homologacao()){
            $inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->get();

            return view('templates.partials.coordenador.homologa_inscricoes', compact('relatorio_disponivel','inscricoes_finalizadas'));    
        }else{
            notify()->flash('As inscrições não terminaram ainda. Não é possível homologar.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }
        
	}

    public function postHomologarInscritos(Request $request)
    {
        $user = Auth::user();

        $id_user = $user->id_user;

        $locale = "pt-br";

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        if ($relatorio->autoriza_inscricao()) {
            
            notify()->flash('As inscrições não terminaram ainda. Não é possível homologar.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }
        
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

            $homologa->homologada = explode("_", $homologar)[0];

            $homologa->id_coordenador = $id_user;

            $homologa->save();
        }

        notify()->flash('Dados salvos com sucesso.','success', [
            'timer' => 2000,
        ]);

        $edital = str_pad(explode("-",$relatorio_disponivel->edital)[1], 2, '0', STR_PAD_LEFT)."/".explode("-",$relatorio_disponivel->edital)[0];

        $numero_pragramas = count(explode("_", $relatorio_disponivel->programa));

        if ($numero_pragramas > 1) {
            $texto_cursos_pos = "os cursos de Doutorado e Mestrado";
        }else{
            $texto_cursos_pos = "o curso de ".(new ProgramaPos())->pega_programa_pos_mat($relatorio_disponivel->programa, $locale);
        }

        dd($texto_cursos_pos);

        $pdf = PDF::loadView('templates.partials.coordenador.pdf_homologacoes', compact('edital', 'texto_cursos_pos'));
        
        return $pdf->stream();
        
        // return redirect()->back();
    }
}