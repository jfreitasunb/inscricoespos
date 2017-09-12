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
        'nome',
    ];

    public function pega_disciplinas_monitoria()
    {
    
        $disciplinas_para_monitoria = $this->select('codigo', 'nome')->orderBy('nome')->get();

        return $disciplinas_para_monitoria;
    }

    public function retorna_nome_pelo_codigo($codigo)
    {
        $nome_disciplina = $this->select('nome')->where('codigo',$codigo)->get();

        return $nome_disciplina;

    }
}