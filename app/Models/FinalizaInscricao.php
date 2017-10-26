<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class FinalizaInscricao extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'finaliza_inscricao';

    protected $fillable = [
    ];

    public function retorna_inscricao_finalizada($id_user,$id_inscricao_pos)
    {
        $finalizou_inscricao = $this->select('finalizada')->where("id_user", $id_user)->where("id_inscricao_pos", $id_inscricao_pos)->get();

        if (count($finalizou_inscricao)>0 and $finalizou_inscricao[0]['finalizada']) {
        	return TRUE;
        }else{
        	return FALSE;
        }

    }

    public function retorna_usuarios_relatorios($id_inscricao_pos)
    {

        return $this->get()->where("id_inscricao_pos", $id_inscricao_pos)->where('finalizada',TRUE);
    }
}
