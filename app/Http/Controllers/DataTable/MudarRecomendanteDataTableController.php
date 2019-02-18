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
use DB;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Notifications\NotificaRecomendante;

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
        $this->validate($request, [
            'id_candidato' => 'required',
            'id_recomendante' => 'required',
            'nome_recomendante' => 'required',
            'email_recomendante' => 'required|email',
        ]);

        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $id_inscricao_pos = $relatorio_disponivel->id_inscricao_pos;

        $id_candidato = (int)$request->id_candidato;

        $id_recomendante = (int)$request->id_recomendante;

        $email_recomendante = strtolower(trim($request->email_recomendante));

        $nome_recomendante = trim($request->nome_recomendante);

        $email_candidato = strtolower(trim($request->email_candidato));
        
        $novo_recomendante['nome'] = $nome_recomendante;
        
        $novo_recomendante['email'] = $email_recomendante;

        $user_recomendante = new User;

        $acha_recomendante = $user_recomendante->retorna_user_por_email($email_recomendante);

        if (is_null($acha_recomendante)) {
            
            $user_recomendante->registra_recomendante($novo_recomendante);
            
            $id_novo_recomendante = $user_recomendante->retorna_user_por_email($email_recomendante)->id_user;
        }else{

            if ($acha_recomendante->user_type === 'recomendante') {
                $id_novo_recomendante = $acha_recomendante->id_user;
            }else{

                notify()->flash('O e-mail: '.$email_recomendante.' pertence a um candidato!','error');
                return redirect()->back();
            }   
        }

        $carta_recomendacao = new CartaRecomendacao();

        $ja_enviou_carta = $carta_recomendacao->retorna_carta_recomendacao($id_recomendante, $id_candidato, $id_inscricao_pos);

        if ($ja_enviou_carta->completada) {
            
            return redirect()->back();
            
        }else{
            $mudou_recomendante = DB::table('cartas_recomendacoes')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('id_recomendante', $id_recomendante)->where('completada', false)->update(['id_recomendante' => $id_novo_recomendante, 'updated_at' => date('Y-m-d H:i:s') ]);

            DB::table('contatos_recomendantes')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('id_recomendante', $id_recomendante)->update(['id_recomendante' => $id_novo_recomendante, 'updated_at' => date('Y-m-d H:i:s') ]);

            $edital = ConfiguraInscricaoPos::find($id_inscricao_pos);

            $prazo_envio = Carbon::createFromFormat('Y-m-d', $edital->prazo_carta);

            $dados_email['nome_professor'] = $nome_recomendante;
            $dados_email['nome_candidato'] = $request->nome_candidato;
            $dados_email['programa'] = $request->programa;
            $dados_email['email_recomendante'] = $email_recomendante;
            $dados_email['prazo_envio'] = $prazo_envio->format('d/m/Y');

            Notification::send(User::find($id_novo_recomendante), new NotificaRecomendante($dados_email));
        }
    }
}
