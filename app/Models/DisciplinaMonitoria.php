<?php

namespace Monitoriamat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DisciplinaMonitoria extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id';

    protected $table = 'disciplinas_monitoria';

    protected $fillable = [
        'id_monitoria',
        'codigo_disciplina', 
    ];

    public function pega_disciplinas_monitoria($id_monitoria){

        $disciplinas = DB::table('disciplinas_mat')
            ->select('codigo', 'nome')
            ->join('disciplinas_monitoria', 'codigo', '=', 'codigo_disciplina')
            ->where('id_monitoria', $id_monitoria)->orderBy('nome')
            ->get();
            
        return $disciplinas;
    }
}