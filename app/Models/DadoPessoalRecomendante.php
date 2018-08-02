<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;

class DadoPessoalRecomendante extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'dados_pessoais_recomendantes';

    protected $fillable = [
        'instituicao_recomendante',
        'titulacao_recomendante',
        'area_recomendante',
        'ano_titulacao',
        'inst_obtencao_titulo',
        'endereco_recomendante',
    ];

    public function dados_atualizados_recomendante($id_recomendante)
    {
        return $this->select('atualizado')->where("id_recomendante", $id_recomendante)->get()->first();
    }

    public function retorna_dados_pessoais_recomendante($id_user)
    {
        return $this->where('id_recomendante', $id_user)->join('users', 'users.id_user', 'dados_pessoais_recomendantes.id_recomendante')->select('users.nome', 'users.email', 'dados_pessoais_recomendantes.*')->get()->first();
    }
}
