<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class DadoRecomendante extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'dados_recomendantes';

    protected $fillable = [
        'nome_recomendante',
        'instituicao_recomendante',
        'titulacao_recomendante',
        'area_recomendante',
        'ano_titulacao',
        'inst_obtencao_titulo',
        'endereco_recomendante',
    ];

    public function retorna_dados_pessoais_recomendante($id_user)
    {
        return $this->where("id_prof", $id_user)->get()->first();
    }
}
