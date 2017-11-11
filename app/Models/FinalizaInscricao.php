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

    public function retorna_usuarios_relatorio_individual($id_inscricao_pos)
    {
        return $this->where('finaliza_inscricao.id_inscricao_pos', $id_inscricao_pos)->where('finaliza_inscricao.finalizada', true)->join('dados_pessoais', 'dados_pessoais.id_user','finaliza_inscricao.id_user')->join('escolhas_candidato', 'escolhas_candidato.id_user', 'dados_pessoais.id_user')->where('escolhas_candidato.id_inscricao_pos', $id_inscricao_pos)->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->select('finaliza_inscricao.id_user', 'finaliza_inscricao.id_inscricao_pos','dados_pessoais.nome','programa_pos_mat.tipo_programa_pos')->orderBy('escolhas_candidato.programa_pretendido' , 'desc')->orderBy('dados_pessoais.nome','asc');
    }
}
