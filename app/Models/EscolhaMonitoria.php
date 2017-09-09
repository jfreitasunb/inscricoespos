<?php

namespace Monitoriamat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class EscolhaMonitoria extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'escolhas_candidato';

    protected $fillable = [
        'escolha_aluno',
        'mencao_aluno',
    ];

public function retorna_escolha_monitoria($id_user,$id_monitoria)
    {
        $escolheu_monitoria = $this->where("id_user", $id_user)->where("id_monitoria", $id_monitoria)->get();

        return $escolheu_monitoria;

    }

}
