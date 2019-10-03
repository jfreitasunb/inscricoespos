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
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\Documento;

use Storage;
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
            'updated_at' => 'Última atualização',
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
            
            $id_candidato = $dados->id_candidato;

            $escolha = new EscolhaCandidato();
            
            if (!is_object($escolha->retorna_escolha_candidato($id_candidato, $id_inscricao_pos))) {
                $programa_pretendido = null;
            }else{
                $id_programa_pretendido = $escolha->retorna_escolha_candidato($id_candidato, $id_inscricao_pos)->programa_pretendido;
                $programa_pretendido = (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr;
            }

            $contatos = new ContatoRecomendante();
            
            $situacao_recomendante = $contatos->retorna_recomendante_candidato($id_candidato,$id_inscricao_pos);
            if (!is_null($situacao_recomendante)) {
                $i=1;
                foreach ($situacao_recomendante as $situacao) {
                    $recomendante[$i] = $situacao->email_enviado;
                    $i++;
                }
            }else{
                $recomendante[1] = null;
                $recomendante[2] = null;
                $recomendante[3] = null;
            }

            $documentos_enviados = new Documento();

            if ($documentos_enviados->retorna_existencia_documentos($id_candidato, $id_inscricao_pos)){
                
                $documentos = url('/').Storage::url($documentos_enviados->retorna_documento($id_candidato,$id_inscricao_pos)['nome_arquivo']);

                $comprovante = url('/').Storage::url($documentos_enviados->retorna_comprovante_proficiencia($id_candidato,$id_inscricao_pos)['nome_arquivo']);

                $historico = url('/').Storage::url($documentos_enviados->retorna_historico($id_candidato,$id_inscricao_pos)['nome_arquivo']);

                $projeto = url('/').Storage::url($documentos_enviados->retorna_projeto($id_candidato,$id_inscricao_pos)['nome_arquivo']);
            }else{
                $documentos = null;
                $comprovante = null;
                $historico = null;
                $projeto = null;
            }
            

            $dados_vue[] = ['id_candidato' => $id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'email' => (User::find($dados->id_candidato))->email, 'programa_pretendido' => $programa_pretendido, 'created_at' => $dados->created_at->format('d/m/Y'). " ".$dados->created_at->format('H:m'), 'updated_at' => $dados->updated_at->format('d/m/Y'). " ".$dados->updated_at->format('H:m'), 'recomendante1' => $recomendante[1], 'recomendante2' => $recomendante[2], 'recomendante3' => $recomendante[3], 'documentos' => $documentos, 'comprovante' => $comprovante, 'historico' => $historico, 'projeto' => $projeto, 'id_inscricao_pos' => $id_inscricao_pos];
        }
        
        return $dados_vue;
    }

    public function update($id, Request $request)
    {
        
        $id_candidato = explode("_", $id)[0];

        $id_inscricao_pos = explode("_", $id)[1];

        // $this->builder->find($id_user)->update($request->only($this->getUpdatableColumns()));
    }
}
