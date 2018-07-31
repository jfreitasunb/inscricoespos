<?php

namespace InscricoesPos\Models;

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

    public function define_nome_coluna_por_locale($locale)
    {
        switch ($locale) {
            case 'en':
                return 'tipo_programa_pos_en';
                break;

            case 'es':
                return 'tipo_programa_pos_es';
                break;
            
            default:
                return 'tipo_programa_pos_ptbr';
                break;
        }
    }

    public function retorna_candidatos_por_recomendante($id_recomendante, $locale)
    {   
        $nome_coluna = $this->define_nome_coluna_por_locale($locale);

        return $this->where('id_recomendante', $id_recomendante)->join('escolhas_candidato', 'escolhas_candidato.id_candidato', 'contatos_recomendantes.id_candidato')->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->join('users','users.id_user','contatos_recomendantes.id_candidato')->select('contatos_recomendantes.id_candidato', 'contatos_recomendantes.id_recomendante', 'contatos_recomendantes.id_inscricao_pos', 'contatos_recomendantes.created_at', 'users.nome', 'users.email', 'programa_pos_mat.'.$nome_coluna)->orderBy('users.nome', 'asc')->get();
    }

    public function retorna_recomendante_candidato($id_candidato,$id_inscricao_pos)
    {

        return $this->where("id_candidato", $id_candidato)->where("id_inscricao_pos", $id_inscricao_pos)->get();

    }

    public function retorna_indicacoes($id_recomendante,$id_inscricao_pos)
    {

        return $this->where("id_recomendante", $id_recomendante)->where("id_inscricao_pos", $id_inscricao_pos)->get();

    }

    public function processa_indicacoes($id_candidato, $id_inscricao_pos, $email_contatos_recomendantes)
    {

        $candidato_recomendantes = $this->retorna_recomendante_candidato($id_candidato, $id_inscricao_pos);

        if (count($candidato_recomendantes) == 0) {

            for ($i=0; $i < count($email_contatos_recomendantes); $i++) { 
                        
                $novo_recomendante = new ContatoRecomendante();
                $acha_recomendante = new User();

                $novo_recomendante->id_candidato = $id_candidato;

                $novo_recomendante->id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;
                        
                $novo_recomendante->id_inscricao_pos = $id_inscricao_pos;

                $novo_recomendante->save();
            }
        }

        if (count($candidato_recomendantes) == 1 or count($candidato_recomendantes) == 2 ) {
           
           $id_atualizacao = $this->select('id')->where('id_candidato', $id_candidato)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');

           for ($i=0; $i < count($id_atualizacao); $i++) { 
               
                $acha_recomendante = new User();

                $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

                DB::table('contatos_recomendantes')->where('id', $id_atualizacao[$i])->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_recomendante' => $novo_id_recomendante, 'updated_at' => date('Y-m-d H:i:s')]);
            }

            
            for ($j=0; $j < count($email_contatos_recomendantes) - count($candidato_recomendantes); $j++) { 
                $novo_recomendante = new ContatoRecomendante();
                $acha_recomendante = new User();

                $novo_recomendante->id_candidato = $id_candidato;

                $novo_recomendante->id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[($j+count($candidato_recomendantes))])->id_user;
                        
                $novo_recomendante->id_inscricao_pos = $id_inscricao_pos;

                $novo_recomendante->save();   
            }
        }

        if (count($candidato_recomendantes) == 3) {

           $id_atualizacao = $this->select('id')->where('id_candidato', $id_candidato)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');


           for ($i=0; $i < count($email_contatos_recomendantes); $i++) {        
                $acha_recomendante = new User();

                $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

                DB::table('contatos_recomendantes')->where('id', $id_atualizacao[$i])->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_recomendante' => $novo_id_recomendante, 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }
    }
}
