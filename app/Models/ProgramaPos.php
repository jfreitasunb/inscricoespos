<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ProgramaPos extends FuncoesModels
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id_programa_pos';

    protected $table = 'programa_pos_mat';

    protected $fillable = [
        'tipo_programa_pos_ptbr', 
        'tipo_programa_pos_en', 
        'tipo_programa_pos_es', 
    ];

    public function pega_programa_pos_mat($programa, $locale){

        $nome_coluna = $this->define_nome_coluna_programa_pos_mat($locale);

        return $this->select($nome_coluna)
            ->where('id_programa_pos', $programa)
            ->value($nome_coluna);
    }
}