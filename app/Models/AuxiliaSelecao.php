<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class AuxiliaSelecao extends FuncoesModels
{

    protected $primaryKey = 'id';

    protected $table = 'auxilia_selecao';

    protected $fillable = [
        'id_candidato',
        'id_inscricao_pos',
        'programa_pretendido',
        'desclassificado',
        'id_coordenador',
    ];

    public function retorna_inscricoes_auxiliares($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->where('desclassificado', false)->get();
    }

    public function retorna_presenca_tabela_inscricoes_auxiliares($id_inscricao_pos, $id_candidato)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->where('id_candidato', $id_candidato)->count();
    }

    public function retorna_dados_auxiliares_relatorio($id_inscricao_pos, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_tipo_programa_pos($locale);

        return $this->where('auxilia_selecao.id_inscricao_pos', $id_inscricao_pos)->where('auxilia_selecao.desclassificado', false)->join('dados_pessoais_candidato', 'dados_pessoais_candidato.id_candidato','auxilia_selecao.id_candidato')->join('users', 'users.id_user', 'auxilia_selecao.id_candidato')->join('escolhas_candidato', 'escolhas_candidato.id_candidato', 'dados_pessoais_candidato.id_candidato')->where('escolhas_candidato.id_inscricao_pos', $id_inscricao_pos)->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->select('auxilia_selecao.id_candidato', 'auxilia_selecao.id_inscricao_pos','users.nome', 'users.email', 'programa_pos_mat.id_programa_pos', 'programa_pos_mat.'.$nome_coluna)->orderBy('escolhas_candidato.programa_pretendido' , 'desc')->orderBy('users.nome','asc')->get();
    }

    public function atualiza_desclassificado($dados)
    {   
        // dd($dados);
        DB::table('auxilia_selecao')->where('id_candidato', $dados['id_candidato'])->where('id_inscricao_pos', $dados['id_inscricao_pos'])->where('programa_pretendido', $dados['programa_pretendido'])->update(['desclassificado' => true, 'updated_at' => date('Y-m-d H:i:s')]);
    }
}
