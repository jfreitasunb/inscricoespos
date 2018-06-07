<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class DadoPessoalRecomendante extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'dados_pessoais_recomendantes';

    protected $fillable = [
        'nome_recomendante',
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

    // public function grava_dados_iniciais_recomendante($id_recomendante, $nome_recomendante)
    // {
    //     $dados_recomendantes = new DadoPessoalRecomendante();

    //     if (is_null($this->retorna_dados_pessoais_recomendante($id_recomendante))) {
            
    //         $dados_recomendantes->id_recomendante = $id_recomendante;

    //         $dados_recomendantes->nome_recomendante = $nome_recomendante;

    //         $dados_recomendantes->save();
    //     }
    // }
}
