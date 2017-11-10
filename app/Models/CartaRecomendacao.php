<?php

namespace Posmat\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class CartaRecomendacao extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'cartas_recomendacoes';

    protected $fillable = [
        'tempo_conhece_candidato',
        'circunstancia_1',
        'circunstancia_2',
        'circunstancia_3',
        'circunstancia_4',
        'circunstancia_outra',
        'desempenho_academico',
        'capacidade_aprender',
        'capacidade_trabalhar',
        'criatividade',
        'curiosidade',
        'esforco',
        'expressao_escrita',
        'expressao_oral',
        'relacionamento',
        'antecedentes_academicos',
        'possivel_aproveitamento',
        'informacoes_relevantes',
        'como_aluno',
        'como_orientando',
    ];

    public function retorna_cartas_por_recomendante($id_prof)
    {
        return $this->where('id_prof', $id_prof)->where('completada', true)->get();
        // ->join('dados_pessoais', 'dados_pessoais.id_user','contatos_recomendantes.id_user')->join('escolhas_candidato', 'escolhas_candidato.id_user', 'contatos_recomendantes.id_user')->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->select('contatos_recomendantes.id_user', 'contatos_recomendantes.id_recomendante', 'contatos_recomendantes.id_inscricao_pos', 'contatos_recomendantes.created_at', 'dados_pessoais.nome', 'programa_pos_mat.tipo_programa_pos')->orderBy('contatos_recomendantes.created_at', 'desc')->paginate(2)
    }

    public function retorna_carta_recomendacao($id_prof,$id_aluno,$id_inscricao_pos)
    {

        return $this->where("id_prof", $id_prof)->where('id_aluno',$id_aluno)->where("id_inscricao_pos", $id_inscricao_pos)->get()->first();

    }

    public function inicia_carta_candidato($id_aluno, $id_inscricao_pos, $email_contatos_recomendantes)
    {
        
        $cartas_inicializadas = $this->select('id')->where('id_aluno', $id_aluno)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');

        if (count($cartas_inicializadas) == 0) {

            for ($i=0; $i < count($email_contatos_recomendantes); $i++) { 
                        
                $nova_carta_recomendacao = new CartaRecomendacao();

                $escolhas_candidato = new EscolhaCandidato();

                $acha_recomendante = new User();

                $nova_carta_recomendacao->id_prof = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

                $nova_carta_recomendacao->id_aluno = $id_aluno;

                $nova_carta_recomendacao->programa_pretendido = $escolhas_candidato->retorna_escolha_candidato($id_aluno, $id_inscricao_pos)->programa_pretendido;

                $nova_carta_recomendacao->id_inscricao_pos = $id_inscricao_pos;

                $nova_carta_recomendacao->save();
            }
        }

        if (count($cartas_inicializadas) == 1 or count($cartas_inicializadas) == 2 ) {
           
           $id_carta_recomendacoes = $this->select('id')->where('id_aluno', $id_aluno)->where('id_inscricao_pos',$id_inscricao_pos)->where('completada',false)->pluck('id');

           for ($i=0; $i < count($id_carta_recomendacoes); $i++) { 
               
                $acha_recomendante = new User();

                $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;
                
                DB::table('cartas_recomendacoes')->where('id', $id_carta_recomendacoes[$i])->where('id_aluno', $id_aluno)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_prof' => $novo_id_recomendante]);
            }

            
            for ($j=0; $j < count($email_contatos_recomendantes) - count($cartas_inicializadas); $j++) { 
                
                $nova_carta_recomendacao = new CartaRecomendacao();

                $escolhas_candidato = new EscolhaCandidato();

                $nova_carta_recomendacao->id_prof = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[($j+count($cartas_inicializadas))])->id_user;

                $nova_carta_recomendacao->id_aluno = $id_aluno;

                $nova_carta_recomendacao->programa_pretendido = $escolhas_candidato->retorna_escolha_candidato($id_aluno, $id_inscricao_pos)->programa_pretendido;

                $nova_carta_recomendacao->id_inscricao_pos = $id_inscricao_pos;

                $nova_carta_recomendacao->save();
            }
        }

        if (count($cartas_inicializadas) == 3) {

           $id_carta_recomendacoes = $this->select('id')->where('id_aluno', $id_aluno)->where('id_inscricao_pos',$id_inscricao_pos)->where('completada',false)->pluck('id');


           for ($i=0; $i < count($email_contatos_recomendantes); $i++) {        
                $acha_recomendante = new User();

                $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

               DB::table('cartas_recomendacoes')->where('id', $id_carta_recomendacoes[$i])->where('id_aluno', $id_aluno)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_prof' => $novo_id_recomendante]);
            }
        }
    }
}
