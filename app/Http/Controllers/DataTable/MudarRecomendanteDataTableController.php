<?php

namespace InscricoesPos\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\CartaRecomendacao;
use Illuminate\Validation\Rule;

class MudarRecomendanteDataTableController extends DataTableController
{
    public function builder()
    {
        return ContatoRecomendante::query();
    }

    public function getDisplayableColumns()
    {
        return [
            'id_candidato', 'id_recomendante', 'email_enviado',
        ];
    }

    public function getVisibleColumns()
    {
        return [
            'id', 'nome_candidato', 'nome_programa_pretendido', 'nome_recomendante', 'email_recomendante', 'status_carta'
        ];
    }

    public function getUpdatableColumns()
    {
        return [
            'nome_recomendante', 'email_recomendante'
        ];
    }

    public function getCustomColumnNanes()
    {
        return [
            'id' => 'Inscrição',
            'id_candidato' => 'Identificador',
            'nome_candidato' => 'Nome',
            'nome_programa_pretendido' => 'Programa desejado',
            'nome_recomendante' => 'Nome Recomendante',
            'email_recomendante' => 'E-mail Recomendante',
            'status_carta' => 'Carta enviada?'
        ];
    }

    public function index(Request $request)
    {   
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        return response()->json([
            'data' => [
                'table' => $this->builder->getModel()->getTable(),
                'displayable' => array_values($this->getDisplayableColumns()),
                'visivel' => array_values($this->getVisibleColumns()),
                'updatable' => $this->getUpdatableColumns(),
                'custom_columns' => $this->getCustomColumnNanes(),
                'records' => $this->getRecords($request),
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

        $dados_temporarios = $this->builder()->limit($request->limit)->where('id_inscricao_pos', $id_inscricao_pos)->orderBy('id_candidato')->get($this->getDisplayableColumns());

        $i = 1;

        if (sizeof($dados_temporarios) > 0) {
            foreach ($dados_temporarios as $dados) {

                $escolha = new EscolhaCandidato();

                $id_programa_pretendido = $escolha->retorna_escolha_candidato($dados->id_candidato, $id_inscricao_pos)->programa_pretendido;

                $carta = new CartaRecomendacao();

                $status_carta = $carta->retorna_status_carta_recomendacao($dados->id_recomendante, $dados->id_candidato, $id_inscricao_pos);
                
                $dados_vue[] = ['id' => $i, 'id_candidato' => $dados->id_candidato, 'nome_candidato' => (User::find($dados->id_candidato))->nome, 'nome_programa_pretendido' => (ProgramaPos::find($id_programa_pretendido))->tipo_programa_pos_ptbr, "id_programa_pretendido" => $id_programa_pretendido, 'id_recomendante' => $dados->id_recomendante, 'nome_recomendante' => (User::find($dados->id_recomendante))->nome, 'email_recomendante' => (User::find($dados->id_recomendante))->email, 'status_carta' => $status_carta];

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
