<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;

use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\User;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\EscolhaCandidato;

use DB;

class ListaRecomendacoesAtivasDataTableController extends DataTableController
{
    public function builder()
    {
        return FinalizaInscricao::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_candidato', 'id_inscricao_pos'
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'nome', 'nome_programa_pretendido'
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
            'nome' => 'Nome do Candidato',
            'nome_programa_pretendido' => 'Programa'
        ];
    }

    public function index(Request $request)
    {   
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $edital_vigente = explode("-",$relatorio_disponivel->edital)[1]."/".explode("-",$relatorio_disponivel->edital)[0];

        $finalizacoes = new FinalizaInscricao;

        $totaliza = new CartaRecomendacao();

        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
                'visivel' => array_values($this->getVisibleColumns()),
                'custom_columns' => $this->getCustomColumnNanes(),
                'updatable' => $this->getUpdatableColumns(),
                'edital' => $edital_vigente,
                'total_cartas_solicitas' => $finalizacoes->retorna_total_inscricoes_finalizadas($id_inscricao_pos)*3,
                'total_cartas_recebidas' => $totaliza->conta_total_cartas_por_edital_situacao($id_inscricao_pos, true),
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

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $dados_temporarios = $this->builder()->limit($request->limit)->where('finalizada', TRUE)->where('id_inscricao_pos', $id_inscricao_pos)->orderBy('id_candidato')->get($this->getDisplayableColumns());
        

        if (sizeof($dados_temporarios) > 0) {

            foreach ($dados_temporarios as $dados) {

            $recomendante_candidato = new ContatoRecomendante();

            $recomendantes_candidato = $recomendante_candidato->retorna_recomendante_candidato($dados->id_candidato, $id_inscricao_pos);

            $i = 1;

            $dados_temporarios = [];

            foreach ($recomendantes_candidato as $recomendante) {

                $usuario_recomendante = User::find($recomendante->id_recomendante);

                $dados_temporarios['email_recomendante_'.$i] = $usuario_recomendante->email;

                $dados_temporarios['nome_recomendante_'.$i] = $usuario_recomendante->nome;

                $carta_recomendacao = new CartaRecomendacao();
                    
                $carta_aluno = $carta_recomendacao->retorna_carta_recomendacao($recomendante->id_recomendante,$dados->id_candidato,$id_inscricao_pos);

                $dados_temporarios['status_carta_'.$i] = $carta_aluno->completada;

                $i++;
            }

            // dd($dados_temporarios);
            $escolha = new EscolhaCandidato();

            $programa_pretendido = $escolha->retorna_escolha_candidato($dados->id_candidato, $id_inscricao_pos)->programa_pretendido;

            $dados_vue[] = ['id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'email' => (User::find($dados->id_candidato))->email, 'nome_programa_pretendido' => (ProgramaPos::find($programa_pretendido))->tipo_programa_pos_ptbr, 'email_recomendante_1' => $dados_temporarios['email_recomendante_1'], 'nome_recomendante_1' => $dados_temporarios['nome_recomendante_1'], 'status_carta_1' => $dados_temporarios['status_carta_1'], 'email_recomendante_2' => $dados_temporarios['email_recomendante_2'], 'nome_recomendante_2' => $dados_temporarios['nome_recomendante_2'], 'status_carta_2' => $dados_temporarios['status_carta_2'], 'email_recomendante_3' => $dados_temporarios['email_recomendante_3'], 'nome_recomendante_3' => $dados_temporarios['nome_recomendante_3'], 'status_carta_3' => $dados_temporarios['status_carta_3'] ];
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
