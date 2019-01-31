<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\User;
use InscricoesPos\Models\AuxiliaSelecao;

class AuxiliaSelecaoDataTableController extends DataTableController
{
    public function builder()
    {
        return AuxiliaSelecao::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_candidato', 'id_inscricao_pos', 'programa_pretendido'
        ];
    }

    public function getUpdatableColumns()
    {
        return [
            'desclassificado'
        ];
    }

    public function index(Request $request)
    {   
        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
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
        return $this->builder()->limit($request->limit)->orderBy('id_candidato')->get($this->getDisplayableColumns());
    }
}
