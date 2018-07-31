<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidatosSelecionados extends Model
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
        'id_coordenador',
        'deleted_at',
    ];

    public function define_nome_coluna_por_locale($locale)
    {
        switch ($locale) {
            case 'en':
                return 'tipo_programa_pos_en';
                break;

            case 'es':
                return 'tipo_programa_pos_es';
                break;
            
            default:
                return 'tipo_programa_pos_ptbr';
                break;
        }
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
        $nome_coluna = $this->define_nome_coluna_por_locale($locale);

        return $this->where('candidatos_selecionados.id_inscricao_pos', $id_inscricao_pos)->where('candidatos_selecionados.selecionado', true)->join('dados_pessoais_candidato', 'dados_pessoais_candidato.id_candidato','candidatos_selecionados.id_candidato')->join('users', 'users.id_user', 'candidatos_selecionados.id_candidato')->join('escolhas_candidato', 'escolhas_candidato.id_candidato', 'dados_pessoais_candidato.id_candidato')->where('escolhas_candidato.id_inscricao_pos', $id_inscricao_pos)->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->select('candidatos_selecionados.id_candidato', 'candidatos_selecionados.id_inscricao_pos', 'candidatos_selecionados.confirmou_presenca','users.nome', 'users.email', 'programa_pos_mat.id_programa_pos', 'programa_pos_mat.'.$nome_coluna)->orderBy('escolhas_candidato.programa_pretendido' , 'desc')->orderBy('users.nome','asc');
    }
}
