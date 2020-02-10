<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\User;
use InscricoesPos\Models\AuxiliaSelecao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DocumentoMatricula;
use InscricoesPos\Models\ConfiguraInscricaoPos;

use DB;
use File;
use URL;

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
        if (is_null($request->id)) {
            $dados_temporarios = $this->builder()->limit($request->limit)->where('arquivo_final', TRUE)->orWhere('nome_arquivo', 'NULL')->orderBy('id_candidato')->get($this->getDisplayableColumns());
        }else{

            $id_inscricao_pos = $request->id;

            $dados_temporarios = $this->builder()->limit($request->limit)->where('arquivo_final', TRUE)->where('id_inscricao_pos', $id_inscricao_pos)->orWhere('nome_arquivo', 'NULL')->orderBy('id_candidato')->get($this->getDisplayableColumns());
        }

        $url_arquivo = URL::to('/')."/".str_replace('/var/www/inscricoespos/storage/app/public','storage',storage_path('app/public/relatorios/'));


        if (sizeof($dados_temporarios) > 0) {
            foreach ($dados_temporarios as $dados) {

            $nome_final = str_replace(' ', '_',strtr((User::find($dados->id_candidato))->nome, $this->normalizeChars)).".pdf";

            if ($dados->arquivo_final) {
                $link_arquivo = $url_arquivo.$dados->nome_arquivo;
            }else{
                $link_arquivo = NULL;
            }

            $edital = new ConfiguraInscricaoPos();
                
            $temp = explode("-", $edital->retorna_edital_vigente($dados->id_inscricao_pos)->edital);

            $dados_vue[] = ['id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($dados->id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, 'edital' => $temp[1]."/".$temp[0],"id_programa_pretendido" => $dados->id_programa_pretendido, 'link_arquivo' => $link_arquivo, 'nome_tratado' => $nome_final, 'arquivo_final' => $dados->arquivo_final];
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
