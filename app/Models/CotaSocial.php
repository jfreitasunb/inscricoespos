<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class CotaSocial extends FuncoesModels
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id';

    protected $table = 'cota_social';

    protected $fillable = [
        'tipo_programa_pos_ptbr', 
        'cota_social_ptbt',
        'cota_social_es',
        'cota_social_en',
    ];

    public function define_nome_coluna_cota_social($locale)
    {
        switch ($locale) {
            case 'en':
                return 'cota_social_en';
                break;

            case 'es':
                return 'cota_social_es';
                break;
            
            default:
                return 'cota_social_ptbr';
                break;
        }
    }

    public function pega_programa_cota_social($id, $locale){

        $nome_coluna = $this->define_nome_coluna_cota_social($locale);

        return $this->select($nome_coluna)
        ->where('id', $id)
        ->value($nome_coluna);
    }
}