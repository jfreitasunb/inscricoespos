<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class CandidatosSelecionados extends FuncoesModels
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $table = 'candidatos_selecionados';

    protected $fillable = [
        'id_candidato',
        'id_inscricao_pos',
        'programa_pretendido',
        'selecionado',
        'confirmou_presenca',
        'inicio_no_programa',
        'id_coordenador',
        'deleted_at',
    ];


    public function retorna_status_selecionado($id_inscricao_pos, $id_candidato)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->where('id_candidato', $id_candidato)->get()->first();
    }

    public function retorna_candidatos_selecionados($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->where('selecionado', 'True')->get();
    }

    public function limpa_selecoes_anteriores($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->delete();
    }

    public function retorna_dados_candidatos_selecionados($id_inscricao_pos, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_tipo_programa_pos($locale);

        return $this->where('candidatos_selecionados.id_inscricao_pos', $id_inscricao_pos)->where('candidatos_selecionados.selecionado', true)->join('dados_pessoais_candidato', 'dados_pessoais_candidato.id_candidato','candidatos_selecionados.id_candidato')->join('users', 'users.id_user', 'candidatos_selecionados.id_candidato')->join('escolhas_candidato', 'escolhas_candidato.id_candidato', 'dados_pessoais_candidato.id_candidato')->where('escolhas_candidato.id_inscricao_pos', $id_inscricao_pos)->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->select('candidatos_selecionados.id_candidato', 'candidatos_selecionados.id_inscricao_pos', 'candidatos_selecionados.confirmou_presenca', 'candidatos_selecionados.inicio_no_programa', 'users.nome', 'users.email', 'programa_pos_mat.id_programa_pos', 'programa_pos_mat.'.$nome_coluna)->orderBy('escolhas_candidato.programa_pretendido' , 'desc')->orderBy('users.nome','asc')->get();
    }

    public function grava_resposta_participacao($id_candidato, $id_inscricao_pos, $confirmou_presenca, $id_inicio_programa)
    {
        $id = $this->select('id')->where('id_inscricao_pos', $id_inscricao_pos)->where('id_candidato', $id_candidato)->value('id');

        $status_gravacao = DB::table('candidatos_selecionados')->where('id', $id)->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update(['confirmou_presenca' => $confirmou_presenca, 'inicio_no_programa' => $id_inicio_programa, 'updated_at' => date('Y-m-d H:i:s')]);

        return $status_gravacao;
    }
}
