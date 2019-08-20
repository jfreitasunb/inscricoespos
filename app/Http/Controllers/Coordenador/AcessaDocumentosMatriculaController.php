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
use InscricoesPos\Models\ConfiguraEnvioDocumentosMatricula;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DocumentoMatricula;
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

    public function getAcessoDocumentosMatricula()
    {
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $configura_envio_documentos = new ConfiguraEnvioDocumentosMatricula;

        if ($configura_envio_documentos->libera_tela_documento_matricula($id_inscricao_pos)){

            $selecionados_documentos = new DocumentoMatricula();

            $candidatos = $selecionados_documentos->retorna_usuarios_documentos_enviados($id_inscricao_pos);

            foreach ($candidatos as $candidato) {
                
                $id_candidato = $candidato->id_candidato;

                $dados_template[$id_candidato]['nome_candidato'] = 'nome';

                $dados_template[$id_candidato]['programa_pretendido'] = 'programa_pretendido';

                $dados_template[$id_candidato]['arquivo_final'] = (!is_null($selecionados_documentos->retorna_se_arquivo_foi_enviado($id_candidato, $id_inscricao_pos, $id_programa_pretendido, 'df')) ? True: False);

                $dados_template[$id_candidato]['nome_arquivo'] = 'nome_arquivo';
            }

            dd($dados_template);

            return view('templates.partials.coordenador.acessa_documentos_matricula');    
        }else{
            notify()->flash('Tela indisponível. Ainda não está no período de envio de documentos.','warning', [
                'timer' => 3000,
            ]);

            return redirect()->back();
        }
    }
}