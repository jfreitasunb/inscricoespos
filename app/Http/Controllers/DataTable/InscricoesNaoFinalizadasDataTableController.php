<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;
use Carbon\Carbon;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\ProgramaPos;


use DB;

class InscricoesNaoFinalizadasDataTableController extends DataTableController
{
    public function builder()
    {
        return FinalizaInscricao::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_candidato', 'created_at', 'updated_at'
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'id_candidato', 'nome', 'email', 'programa_pretendido', 'created_at', 'updated_at'
        ];
    }

    public function getCustomColumnNanes()
    {
        return [
            'id_candidato' => 'Identificador',
            'nome' => 'Nome',
            'email' => 'Email',
            'programa_pretendido' => 'Programa Pretendido',
            'created_at' => 'Criação',
            'updated_at' => 'Última atualização'
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
        $edital = new ConfiguraInscricaoPos();

        $edital_vigente = $edital->retorna_edital_vigente();

        $id_inscricao_pos = $edital_vigente->id_inscricao_pos;

        $dados_temporarios = $this->builder()->limit($request->limit)->where('id_inscricao_pos', $id_inscricao_pos)->where('finalizada', FALSE)->orderBy('id_candidato')->get($this->getDisplayableColumns());

        foreach ($dados_temporarios as $dados) {
            
            $escolha = new EscolhaCandidato();

            $id_programa_pretendido = $escolha->retorna_escolha_candidato($dados->id_candidato, $id_inscricao_pos)->programa_pretendido;

            $dados_vue[] = ['id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'email' => (User::find($dados->id_candidato))->email, 'programa_pretendido' => (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr, 'created_at' => $dados->created_at->format('d/m/Y'). " ".$dados->created_at->format('H:m'), 'updated_at' => $dados->updated_at->format('d/m/Y'). " ".$dados->updated_at->format('H:m')];
        }
        
        return $dados_vue;
    }
}
