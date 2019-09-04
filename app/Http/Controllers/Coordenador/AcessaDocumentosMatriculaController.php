<?php

namespace InscricoesPos\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use PDF;
use Storage;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\AuxiliaSelecao;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\ConfiguraEnvioDocumentosMatricula;
use InscricoesPos\Models\DocumentoMatricula;
use InscricoesPos\Models\ProgramaPos;
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
    protected $normalizeChars = array(
      'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
      'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
      'Ï'=>'I', 'Ñ'=>'N', 'Ń'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
      'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
      'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
      'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ń'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
      'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f',
      'ă'=>'a', 'î'=>'i', 'â'=>'a', 'ș'=>'s', 'ț'=>'t', 'Ă'=>'A', 'Î'=>'I', 'Â'=>'A', 'Ș'=>'S', 'Ț'=>'T',
    );

    public function index()
    {
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $configura_envio_documentos = new ConfiguraEnvioDocumentosMatricula;

        if ($configura_envio_documentos->libera_tela_documento_matricula($id_inscricao_pos)){

            return view('templates.partials.coordenador.acessa_documentos_matricula');    
        }else{
            notify()->flash('As inscrições não terminaram ainda. Não é possível ver os documentos enviados.','warning', [
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

        $candidatos_com_documentos = $documentos_matricula->retorna_usuarios_documentos_final($id_inscricao_pos);

        $local_arquivos_zipar = storage_path('app/arquivos_internos/').$edital;

        $local_zip = storage_path('app/arquivos_internos/');

        File::isDirectory($local_zip) or File::makeDirectory($local_zip,0775,true);

        foreach ($candidatos_com_documentos as $candidato) {

            $nome_arquivo = str_replace(' ', '_',strtr((User::find($candidato->id_candidato))->nome, $this->normalizeChars))."_".(ProgramaPos::find($candidato->id_programa_pretendido))->tipo_programa_pos_ptbr.".pdf";

            File::copy(storage_path('app/').$candidato->nome_arquivo, $local_zip.'/'.$nome_arquivo);
        }



        $zip = new ZipArchive;

        if ( $zip->open( $local_zip.$nome_arquivo_ZIP, ZipArchive::CREATE ) === true ){
            
            foreach (glob( $local_arquivos_zipar.'*.pdf') as $fileName ){
                $file = basename( $fileName );
                $zip->addFile( $fileName, $file );
            }

            $zip->close();
        }

        File::deleteDirectory(storage_path('app/arquivos_internos/').$edital);

        return Response::download($local_zip.$nome_arquivo_ZIP, $nome_arquivo_ZIP);
        
    }
}