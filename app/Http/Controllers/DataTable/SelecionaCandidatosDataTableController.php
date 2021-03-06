<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\User;
use InscricoesPos\Models\AuxiliaSelecao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\HomologaInscricoes;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\CandidatosSelecionados;

use Auth;
use DB;

class SelecionaCandidatosDataTableController extends DataTableController
{
    public function builder()
    {
        return HomologaInscricoes::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_candidato', 'id_inscricao_pos',
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'id', 'nome', 'nome_programa_pretendido', 'classificacao'
        ];
    }

    public function getCustomColumnNanes()
    {
        return [
            'id' => 'Inscrição',
            'id_candidato' => 'Identificador',
            'nome' => 'Nome',
            'nome_programa_pretendido' => 'Programa Desejado',
            'classificacao' => 'Ordem',
            'bolsa_disponivel' => 'Contemplado com bolsa?'
        ];
    }

    public function index(Request $request)
    {   
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;
        
        $finalizadas = new CandidatosSelecionados();

        $total_selecionados = $finalizadas->retorna_total_candidatos_selecionados($id_inscricao_pos);

        $homologa = new HomologaInscricoes();

        $total_homologados =  $homologa->retorna_total_inscricoes_homologadas_validas($id_inscricao_pos);

        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
                'visivel' => array_values($this->getVisibleColumns()),
                'custom_columns' => $this->getCustomColumnNanes(),
                'records' => $this->getRecords($request),
                'total_selecionados' => $total_selecionados,
                'total_homologados' => $total_homologados,
                'id_inscricao_pos' => $id_inscricao_pos
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

        $dados_temporarios = $this->builder()->limit($request->limit)->where('id_inscricao_pos', $id_inscricao_pos)->where('homologada', TRUE)->orderBy('id_candidato')->get($this->getDisplayableColumns());

        $i = 1;

        if (sizeof($dados_temporarios) > 0) {
            foreach ($dados_temporarios as $dados) {

                $escolha = new EscolhaCandidato();

                $id_programa_pretendido = $escolha->retorna_escolha_candidato($dados->id_candidato, $id_inscricao_pos)->programa_pretendido;

                $seleciona = new CandidatosSelecionados();

                $foi_selecionado = $seleciona->retorna_status_selecionado($id_inscricao_pos, $dados->id_candidato);

                if (is_null($foi_selecionado)) {
                    $dados_vue[] = ['id' => $i, 'id_candidato' => $dados->id_candidato, 'nome' => $this->titleCase((User::find($dados->id_candidato))->nome), 'nome_programa_pretendido' => (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, "id_programa_pretendido" => $id_programa_pretendido, 'selecionado' => 'nao_definido', 'contemplado' => ''];
                }else{
                    $dados_vue[] = ['id' => $i, 'id_candidato' => $dados->id_candidato, 'nome' => $this->titleCase((User::find($dados->id_candidato))->nome), 'nome_programa_pretendido' => (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, "id_programa_pretendido" => $id_programa_pretendido, 'selecionado' => $foi_selecionado->selecionado, 'colocacao' => $foi_selecionado->classificacao, 'contemplado_bolsa' => ($foi_selecionado->bolsa_disponivel ? 'Sim' : 'Não')];
                }

                $i++;
            }
        }else{
            $dados_vue = [];
        }
        

        return $dados_vue;
    }

    public function update($id_candidato, Request $request)
    {   
        
        $this->validate($request, [
            'colocacao' => 'integer|required_if:status,1',
            'contemplado_com_bolsa' => 'required_if:status,1',

        ]);

        $user = Auth::user();

        $id_user = $user->id_user;

        $selecionado = new CandidatosSelecionados();

        $id_inscricao_pos = $request->id_inscricao_pos;

        $colocacao = $request->colocacao;

        $bolsa_disponivel = ((int)$request->contemplado_com_bolsa == 1 ? true : false);

        $ja_foi_selecionado = $selecionado->retorna_status_selecionado($id_inscricao_pos, $id_candidato);

        if (is_null($ja_foi_selecionado)) {
            $selecionado->id_candidato = $request->id_candidato;

            $selecionado->id_inscricao_pos = $id_inscricao_pos;

            $selecionado->programa_pretendido = $request->programa_pretendido;

            $selecionado->selecionado = $request->status;

            $selecionado->classificacao = $colocacao;

            $selecionado->id_coordenador = $id_user;

            $selecionado->save();
        }else{
            DB::table('candidatos_selecionados')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('programa_pretendido', $request->programa_pretendido)->update(['selecionado' => $request->status, 'classificacao' => $colocacao , 'updated_at' => date('Y-m-d H:i:s'), 'bolsa_disponivel' => $bolsa_disponivel]);
        }
    }
}
