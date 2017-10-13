<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class EscolhaCandidato extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'escolhas_candidato';

    protected $fillable = [
        'programa_pretendido',
        'area_pos',
        'interesse_bolsa',
        'id_inscricao_pos',
    ];

public function retorna_escolha_candidato($id_user,$id_inscricao_pos)
    {
        $escolheu_monitoria = $this->where("id_user", $id_user)->where("id_inscricao_pos", $id_inscricao_pos)->get();

        return $escolheu_monitoria;

    }

}
