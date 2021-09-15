<?php

namespace InscricoesPos\Models;

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
        'area_pos_principal',
        'area_pos_secundaria',
        'interesse_bolsa',
        'vinculo_empregaticio',
        'id_inscricao_pos',
        'id_tipo_cotista',
    ];

    public function retorna_escolha_candidato($id_candidato,$id_inscricao_pos)
    {
        return $this->where("id_candidato", $id_candidato)->where("id_inscricao_pos", $id_inscricao_pos)->get()->first();
    }

    // public function usuarios_nao_finalizados($id_inscricao_pos)
    // {
    //     return $this->where('id_inscricao_pos', $id_inscricao_pos)->join('users', 'users.id_user', 'escolhas_candidato.id_candidato')->join('programa_pos_mat', 'programa_pos_mat.id_programa_pos', 'escolhas_candidato.programa_pretendido')->whereNotIn('escolhas_candidato.id_candidato', function($query) use ($id_inscricao_pos) {
    //         $query->select('id_candidato')->from('finaliza_inscricao')->where('id_inscricao_pos', $id_inscricao_pos);
    //     } )->select('users.nome', 'programa_pos_mat.tipo_programa_pos_ptbr')->orderBy('programa_pos_mat.tipo_programa_pos_ptbr');
    // }

    public function grava_escolhas_candidato($id_candidato, $id_inscricao_pos, $request)
    {

        $candidato_fez_escolhas = $this->retorna_escolha_candidato($id_candidato,$id_inscricao_pos);

        if (!is_null($candidato_fez_escolhas)) {
            $atualiza_escolhas = $this->where('id_candidato', $id_candidato)->where('id_inscricao_pos',$id_inscricao_pos);
            $dados_escolhas['programa_pretendido'] = (int)$request->programa_pretendido;
            if ($request->programa_pretendido == 1) {
                $dados_escolhas['area_pos_principal'] = 10;
                $dados_escolhas['area_pos_secundaria'] = 10;
            }else{
                $dados_escolhas['area_pos_principal'] = (int)$request->area_pos_principal;
                $dados_escolhas['area_pos_secundaria'] = (int)$request->area_pos_secundaria;
            }
            $dados_escolhas['interesse_bolsa'] = (bool)$request->interesse_bolsa;
            $dados_escolhas['vinculo_empregaticio'] = (bool)$request->vinculo_empregaticio;

            
            $dados_escolhas['id_tipo_cotista'] = (int)$request->tipo_cotista;
            
            $atualiza_escolhas->update($dados_escolhas);
        }else{
            $escolhas_candidato = new EscolhaCandidato();
            $escolhas_candidato->id_candidato = $id_candidato;
            $escolhas_candidato->programa_pretendido = (int)$request->programa_pretendido;

            if ($request->programa_pretendido == 1) {
                $escolhas_candidato->area_pos_principal = 10;
                $escolhas_candidato->area_pos_secundaria = 10;
            }else{
                $escolhas_candidato->area_pos_principal = (int)$request->area_pos_principal;
                $escolhas_candidato->area_pos_secundaria = (int)$request->area_pos_secundaria;
            }
            $escolhas_candidato->interesse_bolsa = (bool)$request->interesse_bolsa;
            $escolhas_candidato->vinculo_empregaticio = (bool)$request->vinculo_empregaticio;
            $escolhas_candidato->id_inscricao_pos = $id_inscricao_pos;

            $escolhas_candidato->id_tipo_cotista = (int)$request->tipo_cotista;
            
            $escolhas_candidato->save();
        }
    }

    public function retorna_area_distintas($id_inscricao_pos)
    {
        return $this->select('area_pos_principal')->where('id_inscricao_pos', $id_inscricao_pos)->where('programa_pretendido', '2')->distinct()->orderBy('area_pos_principal')->pluck('area_pos_principal');
    }

    public function retorna_inscritos_por_area_pos($area_pos, $id_inscricao_pos)
    {
        return $this->select('id_candidato')->where('programa_pretendido', '2')->where('area_pos_principal', $area_pos)->where('id_inscricao_pos', $id_inscricao_pos)->get()->pluck('id_candidato');
    }
}
