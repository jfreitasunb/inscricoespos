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
use InscricoesPos\Models\DocumentoMatricula;
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

    public function getZIPDocumentosMatricula()
    {

        $user = Auth::user();

        $id_user = $user->id_user;

        $locale = "pt-br";

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $edital = $relatorio_disponivel->edital;

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;
        
        $nome_arquivo_ZIP = "Documentos_Candidatos_Selecionados_Edital_".$edital.".zip";

        $documentos_matricula = new DocumentoMatricula();

        dd($documentos_matricula->retorna_usuarios_documentos_final($id_inscricao_pos));

        // return Response::download($local_arquivo_homologacoes.$nome_arquivo_ZIP, $nome_arquivo_ZIP);
        
    }
}