<?php

namespace Monitoriamat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class FinalizaEscolha extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'finaliza_escolhas';

    protected $fillable = [
        'tipo_monitoria',
        'concorda_termos',
    ];

    public function retorna_inscricao_finalizada($id_user,$id_monitoria)
    {
        $finalizou_inscricao = $this->select('finalizar')->where("id_user", $id_user)->where("id_monitoria", $id_monitoria)->get();

        if (count($finalizou_inscricao)>0 and $finalizou_inscricao[0]['finalizar']) {
        	return TRUE;
        }else{
        	return FALSE;
        }

    }

    public function retorna_usuarios_relatorios($id_monitoria)
    {
        $usarios_relatorios = $this->get()->where("id_monitoria", $id_monitoria)->where('finalizar',TRUE);

        return $usarios_relatorios;

    }
}
