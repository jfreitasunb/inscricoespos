<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaPosMat extends FuncoesModels
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'id';

    protected $table = 'area_pos_mat';

    protected $fillable = [
        'nome_ptbr',
        'nome_en',
        'nome_es',
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('nome_ptbr', 'like', "%{$value}%")->orWhere('nome_en', 'like', "%{$value}%")->orWhere('nome_es', 'like', "%{$value}%");
    }
    public function pega_area_pos_mat($area_pos, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_area_pos_mat($locale);

        if ($area_pos == 0) {
            return null;
        }else{
            return $this->select($nome_coluna)
            ->where('id', $area_pos)->where('id', '!=', 10)
            ->value($nome_coluna);
        }
    }
}
