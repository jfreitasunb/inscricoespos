<?php

namespace Posmat\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class ContatoRecomendante extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'contatos_recomendantes';

    protected $fillable = [
        'id_recomendante',
        'id_inscricao_pos',
    ];

    public function retorna_candidatos_por_recomendante($id_prof)
    {
        return $this->where('id_recomendante', $id_prof)->join('dados_pessoais', 'id_aluno','id_user')->join('escolhas_candidato', 'escolhas_candidato.id_user', 'contatos_recomendantes.id_aluno')->get();
        // ->join('escolhas_candidato', 'escolhas_candidato.id_user', 'contatos_recomendantes.id_aluno')->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')
    }

    public function retorna_recomendante_candidato($id_user,$id_inscricao_pos)
    {

        return $this->where("id_user", $id_user)->where("id_inscricao_pos", $id_inscricao_pos)->get();

    }

     public function retorna_indicacoes($id_user,$id_inscricao_pos)
    {

        return $this->where("id_recomendante", $id_user)->where("id_inscricao_pos", $id_inscricao_pos)->get();

    }

    public function processa_indicacoes($id_aluno, $id_inscricao_pos, $email_contatos_recomendantes)
    {

        $candidato_recomendantes = $this->retorna_recomendante_candidato($id_aluno, $id_inscricao_pos);

        if (count($candidato_recomendantes) == 0) {

            for ($i=0; $i < count($email_contatos_recomendantes); $i++) { 
                        
                $novo_recomendante = new ContatoRecomendante();
                $acha_recomendante = new User();

                $novo_recomendante->id_user = $id_aluno;

                $novo_recomendante->id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;
                        
                $novo_recomendante->id_inscricao_pos = $id_inscricao_pos;

                $novo_recomendante->save();
            }
        }

        if (count($candidato_recomendantes) == 1 or count($candidato_recomendantes) == 2 ) {
           
           $id_atualizacao = $this->select('id')->where('id_user', $id_aluno)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');

           for ($i=0; $i < count($id_atualizacao); $i++) { 
               
                $acha_recomendante = new User();

                $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

                DB::table('contatos_recomendantes')->where('id', $id_atualizacao[$i])->where('id_user', $id_aluno)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_recomendante' => $novo_id_recomendante]);
            }

            
            for ($j=0; $j < count($email_contatos_recomendantes) - count($candidato_recomendantes); $j++) { 
                $novo_recomendante = new ContatoRecomendante();
                $acha_recomendante = new User();

                $novo_recomendante->id_user = $id_aluno;

                $novo_recomendante->id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[($j+count($candidato_recomendantes))])->id_user;
                        
                $novo_recomendante->id_inscricao_pos = $id_inscricao_pos;

                $novo_recomendante->save();   
            }
        }

        if (count($candidato_recomendantes) == 3) {

           $id_atualizacao = $this->select('id')->where('id_user', $id_aluno)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');


           for ($i=0; $i < count($email_contatos_recomendantes); $i++) {        
                $acha_recomendante = new User();

                $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

                DB::table('contatos_recomendantes')->where('id', $id_atualizacao[$i])->where('id_user', $id_aluno)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_recomendante' => $novo_id_recomendante]);
            }
        }
    }
}
