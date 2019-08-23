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
use InscricoesPos\Models\AuxiliaSelecao;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\DadoCoordenadorPos;
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
use Response;
/**
* Classe para visualização da página inicial.
*/
class AcessaDocumentosMatriculaController extends CoordenadorController
{

    public function index()
    {
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $finalizacoes = new FinalizaInscricao;

        if ($relatorio->autoriza_homologacao()){

            return view('templates.partials.coordenador.acessa_documentos_matricula');    
        }else{
            notify()->flash('As inscrições não terminaram ainda. Não é possível homologar.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }
    }

    public function postHomologarInscritos()
    {

        $user = Auth::user();

        $id_user = $user->id_user;

        $locale = "pt-br";

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $edital = $relatorio_disponivel->edital;

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $mes_fim_inscricao = explode("-", $relatorio_disponivel->fim_inscricao)[1];

        return Response::download($local_arquivo_homologacoes.$nome_arquivo_homologacao, $nome_arquivo_homologacao);
        
    }
}