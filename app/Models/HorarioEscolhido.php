<?php

namespace Monitoriamat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class HorarioEscolhido extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'horario_escolhido';

    protected $fillable = [
        'horario_monitoria',
        'dia_semana',
    ];

    public function retorna_horarios_escolhidos($id_user,$id_monitoria)
    {
        $horarios = $this->where("id_user", $id_user)->where("id_monitoria", $id_monitoria)->get();

        return $horarios;

    }

}
