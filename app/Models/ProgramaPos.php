<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ProgramaPos extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id_programa_pos';

    protected $table = 'programa_pos_mat';

    protected $fillable = [
        'tipo_programa_pos', 
    ];

    public function pega_programa_pos_mat($id_monitoria){

        $disciplinas = DB::table('disciplinas_mat')
            ->select('codigo', 'nome')
            ->join('programa_pos_mat', 'codigo', '=', 'codigo_disciplina')
            ->where('id_monitoria', $id_monitoria)->orderBy('nome')
            ->get();
            
        return $disciplinas;
    }
}