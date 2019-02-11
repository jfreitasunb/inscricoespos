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

use Auth;
use DB;

class HomologaInscricoesDataTableController extends DataTableController
{
    public function builder()
    {
        return FinalizaInscricao::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_candidato', 'id_inscricao_pos', 'finalizada',
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'id', 'nome', 'nome_programa_pretendido'
        ];
    }

    // public function getUpdatableColumns()
    // {
    //     return [
    //         'desclassificado'
    //     ];
    // }

    public function getCustomColumnNanes()
    {
        return [
            'id' => 'Inscrição',
            'id_candidato' => 'Identificador',
            'nome' => 'Nome',
            'nome_programa_pretendido' => 'Programa desejado'
        ];
    }

    public function index(Request $request)
    {   
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;
        
        $finalizadas = new FinalizaInscricao();

        $total_inscritos = $finalizadas->retorna_total_inscricoes_finalizadas($id_inscricao_pos);

        $homologa = new HomologaInscricoes();

        $total_homologados =  $homologa->retorna_total_inscricoes_homologadas($id_inscricao_pos);

        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
                'visivel' => array_values($this->getVisibleColumns()),
                'custom_columns' => $this->getCustomColumnNanes(),
                'records' => $this->getRecords($request),
                'total_inscritos' => $total_inscritos,
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

        $dados_temporarios = $this->builder()->limit($request->limit)->where('finalizada', TRUE)->where('id_inscricao_pos', $id_inscricao_pos)->orderBy('id_candidato')->get($this->getDisplayableColumns());

        $i = 1;

        if (sizeof($dados_temporarios) > 0) {
            foreach ($dados_temporarios as $dados) {

                $escolha = new EscolhaCandidato();

                $id_programa_pretendido = $escolha->retorna_escolha_candidato($dados->id_candidato, $id_inscricao_pos)->programa_pretendido;

                $homologa = new HomologaInscricoes();

                $ja_homologou = $homologa->retorna_se_foi_homologado($dados->id_candidato, $id_inscricao_pos);

                if (is_null($ja_homologou)) {
                    $dados_vue[] = ['id' => $i, 'id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, "id_programa_pretendido" => $id_programa_pretendido, 'foi_homologado' => 'nao_definido'];
                }else{
                    $dados_vue[] = ['id' => $i, 'id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, "id_programa_pretendido" => $id_programa_pretendido, 'foi_homologado' => $ja_homologou];
                }

                $i++;
            }
        }else{
            $dados_vue = [];
        }
        

        return $dados_vue;
    }

    protected function getRecordsHomologados(Request $request)
    {   
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $dados_temporarios = $this->builder()->limit($request->limit)->where('finalizada', TRUE)->where('id_inscricao_pos', $id_inscricao_pos)->orderBy('id_candidato')->get($this->getDisplayableColumns());

        $i = 1;

        if (sizeof($dados_temporarios) > 0) {
            foreach ($dados_temporarios as $dados) {

                $escolha = new EscolhaCandidato();

                $id_programa_pretendido = $escolha->retorna_escolha_candidato($dados->id_candidato, $id_inscricao_pos)->programa_pretendido;

                $homologa = new HomologaInscricoes();

                $ja_homologou = $homologa->retorna_se_foi_homologado($dados->id_candidato, $id_inscricao_pos);

                if (is_null($ja_homologou)) {
                    $dados_vue[] = ['id' => $i, 'id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, "id_programa_pretendido" => $id_programa_pretendido, 'foi_homologado' => 'nao_definido'];
                }else{
                    $dados_vue[] = ['id' => $i, 'id_candidato' => $dados->id_candidato, 'nome' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr, 'id_inscricao_pos' => $dados->id_inscricao_pos, "id_programa_pretendido" => $id_programa_pretendido, 'foi_homologado' => $ja_homologou];
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
        $user = Auth::user();

        $id_user = $user->id_user;

        $homologa = new HomologaInscricoes();

        $id_inscricao_pos = $request->id_inscricao_pos;

        $ja_homologou = $homologa->retorna_se_foi_homologado($id_candidato, $id_inscricao_pos);

        if (is_null($ja_homologou)) {
            $homologa->id_candidato = $request->id_candidato;

            $homologa->id_inscricao_pos = $id_inscricao_pos;

            $homologa->programa_pretendido = $request->programa_pretendido;

            $homologa->homologada = $request->status;

            $homologa->id_coordenador = $id_user;

            $homologa->save();
        }else{
            DB::table('homologa_inscricoes')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('programa_pretendido', $request->programa_pretendido)->update(['homologada' => $request->status, 'updated_at' => date('Y-m-d H:i:s')]);
        }

        $auxilia_selecao = new AuxiliaSelecao();

        $esta_presente = $auxilia_selecao->retorna_presenca_tabela_inscricoes_auxiliares($id_inscricao_pos, $id_candidato);

        if ($esta_presente > 0) {
            DB::table('auxilia_selecao')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('programa_pretendido', $request->programa_pretendido)->update(['desclassificado' => !($request->status), 'updated_at' => date('Y-m-d H:i:s')]);
        }else{
            $auxilia_selecao->id_candidato = $id_candidato;

            $auxilia_selecao->id_inscricao_pos = $id_inscricao_pos;

            $auxilia_selecao->programa_pretendido = $request->programa_pretendido;

            $auxilia_selecao->desclassificado = !($request->status);

            $auxilia_selecao->id_coordenador = $id_user;

            $auxilia_selecao->save();
        }
    }

    public function show($id_inscricao_pos)
    {
        dd($id_inscricao_pos);
    }
}
