<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\User;
use InscricoesPos\Models\AuxiliaSelecao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DocumentoMatricula;
use InscricoesPos\Models\ConfiguraInscricaoPos;

use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

use DB;
use File;
use URL;
use Auth;

class DocumentosMatriculaDataTableController extends DataTableController
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

    public function builder()
    {
        return DocumentoMatricula::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_candidato', 'id_inscricao_pos', 'id_programa_pretendido', 'nome_arquivo', 'arquivo_final'
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'id_candidato', 'nome', 'edital', 'nome_programa_pretendido', 'nome_arquivo'
        ];
    }

    public function getUpdatableColumns()
    {
        return [
            'desclassificado'
        ];
    }

    public function getCustomColumnNanes()
    {
        return [
            'id_candidato' => 'Identificador',
            'nome' => 'Nome',
            'edital' => 'Edital',
            'nome_programa_pretendido' => 'Programa desejado',
            'nome_arquivo' => 'Arquivo Enviado'
        ];
    }

    public function index(Request $request)
    {   
        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
                'visivel' => array_values($this->getVisibleColumns()),
                'custom_columns' => $this->getCustomColumnNanes(),
                'updatable' => $this->getUpdatableColumns(),
                'editais' => $this->getEditais(),
                'records' => $this->getRecords($request),
            ]
        ]);
    }

    protected function getDatabaseColumnNames()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }

    protected function getEditais()
    {
        $dados_temporarios = $this->builder()->select('id_inscricao_pos')->distinct()->get();
        if (sizeof($dados_temporarios) > 0) {

            foreach ($dados_temporarios as $dado) {
                
                $edital = new ConfiguraInscricaoPos();
                
                $temp = explode("-", $edital->retorna_edital_vigente($dado->id_inscricao_pos)->edital);
                
                $dados_editais_vue[] = ['id_inscricao_pos' => $dado->id_inscricao_pos, 'edital' => $temp[1]."/".$temp[0]];
            }
        }else{
            $dados_editais_vue = [];
        }

        return $dados_editais_vue;
    }

    protected function getRecords(Request $request)
    {   
        $user = Auth::user();
        
        if (is_null($request->id)) {

            if ($user->user_type === "admin") {
                $dados_temporarios = $this->builder()->limit($request->limit)->orderBy('id_candidato')->get();
            }else{
                $dados_temporarios = $this->builder()->limit($request->limit)->where('arquivo_final', TRUE)->orderBy('id_candidato')->get($this->getDisplayableColumns());
            }
            
        }else{

            $id_inscricao_pos = $request->id;

            if ($user->user_type === "admin") {

                $dados_temporarios = $this->builder()->limit($request->limit)->where('id_inscricao_pos', $id_inscricao_pos)->orderBy('id_candidato')->get($this->getDisplayableColumns());
            }else{
                $dados_temporarios = $this->builder()->limit($request->limit)->where('arquivo_final', TRUE)->where('id_inscricao_pos', $id_inscricao_pos)->orderBy('id_candidato')->get($this->getDisplayableColumns());
            }
        }

        $url_arquivo = URL::to('/')."/".str_replace('/var/www/inscricoespos/storage/app/public','storage',storage_path('app/public/relatorios/'));
        
        if (sizeof($dados_temporarios) > 0) {
            foreach ($dados_temporarios as $dados) {

            $nome_final = str_replace(' ', '_',strtr((User::find($dados->id_candidato))->nome, $this->normalizeChars)).".pdf";

            if ($user->user_type === "admin") {
                
                if ($dados->tipo_arquivo !== "df") {
                    File::copy(storage_path("app/").$dados->nome_arquivo, storage_path("app/public/relatorios/").$dados->nome_arquivo);
                }

                $link_arquivo = $url_arquivo.$dados->nome_arquivo;
                
                $tipo_arquivo = $dados->tipo_arquivo;
            }else{
                if ($dados->arquivo_final) {
                    $link_arquivo = $url_arquivo.$dados->nome_arquivo;
                }else{
                    $link_arquivo = NULL;
                }
                $tipo_arquivo = NULL;
            }
            
            $edital = new ConfiguraInscricaoPos();
                
            $temp = explode("-", $edital->retorna_edital_vigente($dados->id_inscricao_pos)->edital);

            $dados_vue[] = ['id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($dados->id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, 'edital' => $temp[1]."/".$temp[0],"id_programa_pretendido" => $dados->id_programa_pretendido, 'link_arquivo' => $link_arquivo, 'nome_tratado' => $nome_final, 'arquivo_final' => $dados->arquivo_final, 'tipo_arquivo'=> $tipo_arquivo];
            }
        }else{
            $dados_vue = [];
        }
        
        return $dados_vue;
    }

    public function update($id_status, Request $request)
    {   
        $local_documentos = storage_path("app/public/relatorios/matricula/");

        $temp = explode("_", $id_status);

        $id_candidato = $temp[0];

        $id_inscricao_pos = $temp[1];

        $status_arquivo = $temp[2];

        $id_programa_pretendido = $temp[3];

        $nome = User::find($id_candidato)->nome;

        $documentos_matricula = new DocumentoMatricula();

        $arquivos_matricula_recebidos = $documentos_matricula->retorna_documentos_matricula_enviados($id_candidato, $id_inscricao_pos);

        $argumento_pdftk = "";
        foreach ($arquivos_matricula_recebidos as $key) {
            $argumento_pdftk .= storage_path('app/').$key->nome_arquivo." ";
        }

        $nome_arquivo_matricula = str_replace(' ', '-', strtr($nome, $this->normalizeChars)).".pdf";

        $ficha_inscricao = str_replace("storage/relatorios/matricula/", "", $nome_arquivo_matricula);

        $endereco_arquivo_matricula = storage_path("app/public/relatorios/matricula/").$nome_arquivo_matricula;

        $process = new Process('pdftk '.$argumento_pdftk.' cat output '.$endereco_arquivo_matricula);

        $process->setTimeout(3600);
        
        $process->run();

        $arquivo_matricula = new DocumentoMatricula();
                    
        $arquivo_ja_enviado = $arquivo_matricula->retorna_se_arquivo_foi_enviado($id_candidato, $id_inscricao_pos, $id_programa_pretendido, 'df');

        if (is_null($arquivo_ja_enviado)) {

            $nome_final = md5(uniqid($ficha_inscricao, true)).".pdf";

            File::copy($local_documentos.$ficha_inscricao, storage_path("app/public/relatorios/")."arquivos_internos/".$nome_final);

            $arquivo_matricula->id_candidato = $id_candidato;

            $arquivo_matricula->id_inscricao_pos = $id_inscricao_pos;

            $arquivo_matricula->id_programa_pretendido = $id_programa_pretendido;
            
            $arquivo_matricula->tipo_arquivo = 'df';

            $arquivo_matricula->nome_arquivo = "arquivos_internos/".$nome_final;
            
            $arquivo_matricula->arquivo_recebido = Storage::exists($local_documentos.$ficha_inscricao);

            $arquivo_matricula->arquivo_final = True;

            $arquivo_matricula->arquivo_final_valido = True;
            
            $arquivo_matricula->save();
        }else{

            $nome_arquivo = explode("/", $arquivo_ja_enviado);

            File::copy($local_documentos.$ficha_inscricao, storage_path("app/public/relatorios/")."arquivos_internos/".$nome_arquivo[1]);

            $arquivo_matricula->atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, $id_programa_pretendido, 'df', Storage::exists($arquivo_ja_enviado));
        }

        File::delete($local_documentos.$ficha_inscricao);        
    }
}
