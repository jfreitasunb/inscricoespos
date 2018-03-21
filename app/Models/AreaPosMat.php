<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AreaPosMat extends Model
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
        switch ($locale) {
            case 'en':
                $nome_coluna = 'nome_en';
                break;

            case 'es':
                $nome_coluna = 'nome_es';
                break;
            
            default:
                $nome_coluna = 'nome_ptbr';
                break;
        }

        if ($area_pos == 0) {
            return null;
        }else{
            return $this->select($nome_coluna)
            ->where('id_area_pos', $area_pos)
            ->value($nome_coluna);
        }   
    }
}