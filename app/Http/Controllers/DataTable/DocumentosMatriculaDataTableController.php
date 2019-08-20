<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\User;
use InscricoesPos\Models\AuxiliaSelecao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DocumentoMatricula;

use DB;

class DocumentosMatriculaDataTableController extends DataTableController
{
    public function builder()
    {
        return DocumentoMatricula::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_candidato', 'id_inscricao_pos', 'id_programa_pretendido',
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'id_candidato', 'nome', 'nome_programa_pretendido'
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
            'nome_programa_pretendido' => 'Programa desejado'
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

        if (sizeof($dados_temporarios) > 0) {
            foreach ($dados_temporarios as $dados) {

            $dados_vue[] = ['id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($dados->id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, "id_programa_pretendido" => $dados->id_programa_pretendido];
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
