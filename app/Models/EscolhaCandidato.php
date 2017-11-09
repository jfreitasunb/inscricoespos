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
        'vinculo_empregaticio',
        'id_inscricao_pos',
    ];

    public function retorna_escolha_candidato($id_user,$id_inscricao_pos)
    {
        return $this->where("id_user", $id_user)->where("id_inscricao_pos", $id_inscricao_pos)->get()->first();
    }


    public function grava_escolhas_candidato($id_aluno,$id_inscricao_pos,$request)
    {

        $candidato_fez_escolhas = $this->retorna_escolha_candidato($id_aluno,$id_inscricao_pos);

        if (count($candidato_fez_escolhas) > 0) {
            $atualiza_escolhas = $this->where('id_user', $id_aluno)->where('id_inscricao_pos',$id_inscricao_pos);
            $dados_escolhas['programa_pretendido'] = (int)$request->programa_pretendido;
            $dados_escolhas['area_pos'] = (int)$request->area_pos;
            $dados_escolhas['interesse_bolsa'] = (bool)$request->interesse_bolsa;
            $dados_escolhas['vinculo_empregaticio'] = (bool)$request->vinculo_empregaticio;
            $atualiza_escolhas->update($dados_escolhas);
        }else{
            $escolhas_candidato = new EscolhaCandidato();
            $escolhas_candidato->id_user = $id_aluno;
            $escolhas_candidato->programa_pretendido = (int)$request->programa_pretendido;
            $escolhas_candidato->area_pos = (int)$request->areas_pos;
            $escolhas_candidato->interesse_bolsa = (bool)$request->interesse_bolsa;
            $escolhas_candidato->vinculo_empregaticio = (bool)$request->vinculo_empregaticio;
            $escolhas_candidato->id_inscricao_pos = $id_inscricao_pos;
            $escolhas_candidato->save();
        }
    }

}
