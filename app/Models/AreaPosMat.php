<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AreaPosMat extends FuncoesModels
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id_area_pos';

    protected $table = 'area_pos_mat';

    protected $fillable = [
        'nome_ptbr',
        'nome_en',
        'nome_es',
    ];

    public function pega_area_pos_mat($area_pos, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_por_locale($locale);

        if ($area_pos == 0) {
            return null;
        }else{
            return $this->select($nome_coluna)
            ->where('id_area_pos', $area_pos)->where('id_area_pos', '!=', 10)
            ->value($nome_coluna);
        }   
    }
}