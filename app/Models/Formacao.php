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

    protected $fillable = [];

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