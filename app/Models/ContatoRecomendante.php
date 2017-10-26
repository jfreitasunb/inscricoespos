<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class ContatoRecomendante extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'contatos_recomendantes';

    protected $fillable = [
        'id_recomendante',
        'id_inscricao_pos',
    ];

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

        dd("aqui");



                // $atualiza_recomendantes = new ContatoRecomendante();

                //     $atualiza_cartas_recomendacoes = new CartaRecomendacao();

                //     $id_atualizacao = $atualiza_recomendantes->select('id')->where('id_user', $id_aluno)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');

                //     $id_carta_recomendacoes = $atualiza_cartas_recomendacoes->select('id')->where('id_aluno', $id_aluno)->where('id_inscricao_pos',$id_inscricao_pos)->where('completada',false)->pluck('id');

                //     for ($i=0; $i < count($email_contatos_recomendantes); $i++) { 
                        
                        
                //         $acha_recomendante = new User();

                //         $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

                //         DB::table('contatos_recomendantes')->where('id', $id_atualizacao[$i])->where('id_user', $id_aluno)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_recomendante' => $novo_id_recomendante]);

                //         DB::table('cartas_recomendacoes')->where('id', $id_carta_recomendacoes[$i])->where('id_aluno', $id_aluno)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_prof' => $novo_id_recomendante]);
                //     }
    }
}
