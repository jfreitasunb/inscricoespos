<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Formacao extends FuncoesModels
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id';

    protected $table = 'formacao';

    protected $fillable = [
        'tipo_ptbr',
        'tipo_en',
        'tipo_es',
    ];

    public function pega_tipo_formacao($id,$nivel, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_tipo_formacao($locale);
        
        return $this->select($nome_coluna)
            ->where('id', $id)
            ->where('nivel', $nivel)
            ->value($nome_coluna);
    }

     public function retorna_id_formacao($tipo,$nivel, $locale_candidato)
     {
        $nome_coluna = $this->define_nome_coluna_tipo_formacao($locale);

        return $this->select('id')
            ->where($nome_coluna, $tipo)
            ->where('nivel', $nivel)
            ->value('id');
    }
}