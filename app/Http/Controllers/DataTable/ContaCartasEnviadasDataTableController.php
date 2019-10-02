<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\User;
use InscricoesPos\Models\CartaRecomendacao;


use DB;

class ContaCartasEnviadasDataTableController extends DataTableController
{
    public function builder()
    {
        return User::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_user', 'nome', 'email',
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'id_user', 'nome', 'email'
        ];
    }

    public function getCustomColumnNanes()
    {
        return [
            'id_user' => 'Identificador',
            'nome' => 'Nome',
            'email' => 'Email'
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
        $dados_temporarios = $this->builder()->where('user_type', 'recomendante')->orderBy('id_user')->get($this->getDisplayableColumns());

        foreach ($dados_temporarios as $dados) {
            
            $cartas_recebidas = new CartaRecomendacao();

            $total_cartas = $cartas_recebidas->conta_cartas_enviadas_por_recomendante($dados->id_user);

            $dados_vue[] = ['id_user' => $dados->id_user, 'nome' => $dados->nome, 'email' => $dados->email, 'total_cartas' => $total_cartas];
        }
        
        return $dados_vue;
    }
}
