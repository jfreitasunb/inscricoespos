<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Formacao extends Model
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
        switch ($locale) {
            case 'en':
                $nome_coluna = 'tipo_en';
                break;

            case 'es':
                $nome_coluna = 'tipo_es';
                break;
            
            default:
                $nome_coluna = 'tipo_ptbr';
                break;
        }

        return $this->select($nome_coluna)
            ->where('id', $id)
            ->where('nivel', $nivel)
            ->value($nome_coluna);
    }

     public function retorna_id_formacao($tipo,$nivel, $locale_candidato)
     {
        switch ($locale) {
            case 'en':
                $nome_coluna = 'tipo_en';
                break;

            case 'es':
                $nome_coluna = 'tipo_es';
                break;
            
            default:
                $nome_coluna = 'tipo_ptbr';
                break;
        }

        return $this->select('id')
            ->where($nome_coluna, $tipo)
            ->where('nivel', $nivel)
            ->value('id');
    }

    // public function pega_disciplinas_monitoria()
    // {
    
    //     $disciplinas_para_monitoria = $this->select('codigo', 'nome')->orderBy('nome')->get();

    //     return $disciplinas_para_monitoria;
    // }

    // public function retorna_nome_pelo_codigo($codigo)
    // {
    //     $nome_disciplina = $this->select('nome')->where('codigo',$codigo)->get();

    //     return $nome_disciplina;

    // }
}