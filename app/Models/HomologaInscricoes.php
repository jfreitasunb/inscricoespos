<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomologaInscricoes extends FuncoesModels
{

    protected $primaryKey = 'id';

    protected $table = 'homologa_inscricoes';

    protected $fillable = [
        'id_candidato',
        'id_inscricao_pos',
        'programa_pretendido',
        'homologada',
        'id_coordenador',
    ];

    public function retorna_se_foi_homologado($id_candidato, $id_inscricao_pos)
    {
        return $this->select('homologada')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->value('homologada');
    }

    public function retorna_inscricoes_homologadas($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->where('homologada', 'True')->get();
    }

    // public function limpa_homologacoes_anteriores($id_inscricao_pos)
    // {
    //     return $this->where('id_inscricao_pos', $id_inscricao_pos)->delete();
    // }

    public function retorna_dados_homologados($id_inscricao_pos, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_tipo_programa_pos($locale);

        return $this->where('homologa_inscricoes.id_inscricao_pos', $id_inscricao_pos)->where('homologa_inscricoes.homologada', true)->join('dados_pessoais_candidato', 'dados_pessoais_candidato.id_candidato','homologa_inscricoes.id_candidato')->join('users', 'users.id_user', 'homologa_inscricoes.id_candidato')->join('escolhas_candidato', 'escolhas_candidato.id_candidato', 'dados_pessoais_candidato.id_candidato')->where('escolhas_candidato.id_inscricao_pos', $id_inscricao_pos)->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->select('homologa_inscricoes.id_candidato', 'homologa_inscricoes.id_inscricao_pos','users.nome', 'users.email', 'programa_pos_mat.id_programa_pos', 'programa_pos_mat.'.$nome_coluna)->orderBy('escolhas_candidato.programa_pretendido' , 'desc')->orderBy('users.nome','asc');
    }
}
