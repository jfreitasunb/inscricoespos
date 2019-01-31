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
}
