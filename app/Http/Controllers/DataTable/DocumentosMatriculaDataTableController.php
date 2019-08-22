<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\User;
use InscricoesPos\Models\AuxiliaSelecao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DocumentoMatricula;

use DB;
use File;

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
            'id_candidato', 'id_inscricao_pos', 'id_programa_pretendido', 'nome_arquivo'
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'id_candidato', 'nome', 'nome_programa_pretendido', 'nome_arquivo'
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
                'records' => $this->getRecords($request),
            ]
        ]);
    }

    protected function getDatabaseColumnNames()
    {
        return Schema::getColumnListing($this->builder->getModel()->getTable());
    }


    protected function getRecords(Request $request)
    {   
        $dados_temporarios = $this->builder()->limit($request->limit)->where('arquivo_final', TRUE)->orderBy('id_candidato')->get($this->getDisplayableColumns());

        $local_arquivos_matricula = storage_path('app/arquivos_internos/JDHfkI74/');

        $url_arquivo = "http://localhost:8084/inscricoespos/".str_replace('/var/www/inscricoespos/','',storage_path('app/arquivos_internos/JDHfkI74/'));

        File::isDirectory($local_arquivos_matricula) or File::makeDirectory($local_arquivos_matricula,0775,true);

        if (sizeof($dados_temporarios) > 0) {
            foreach ($dados_temporarios as $dados) {

            $link_arquivo_original = storage_path('app/').$dados->nome_arquivo;

            $nome_final = str_replace(' ', '_',strtr((User::find($dados->id_candidato))->nome, $this->normalizeChars)).".pdf";

            File::copy($link_arquivo_original, $local_arquivos_matricula.$nome_final);

            $dados_vue[] = ['id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($dados->id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, "id_programa_pretendido" => $dados->id_programa_pretendido, 'link_arquivo' => $url_arquivo.$nome_final, 'nome_tratado' => $nome_final];
            }
        }else{
            $dados_vue = [];
        }
        
        return $dados_vue;
    }

    public function update($id_candidato, Request $request)
    {   
        DB::table('auxilia_selecao')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $request->id_inscricao_pos)->where('programa_pretendido', $request->programa_pretendido)->update(['desclassificado' => true, 'updated_at' => date('Y-m-d H:i:s')]);
    }
}
