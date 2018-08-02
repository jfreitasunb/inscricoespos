<?php

namespace InscricoesPos\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class CartaRecomendacao extends FuncoesModels
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

    public function reativa_carta_finalizada($id_inscricao_pos, $id_candidato, $id_recomendante, $completada)
    {

        $this->where('id_inscricao_pos', $id_inscricao_pos)->where('id_recomendante', $id_recomendante)->where('id_candidato', $id_candidato)->update(['completada' => $completada, 'updated_at' => date('Y-m-d H:i:s') ]);
    }

    public function conta_cartas_enviadas_por_candidato($id_inscricao_pos, $id_candidato)
    {
        return $this->where('id_inscricao_pos',$id_inscricao_pos)->where('id_candidato',$id_candidato)->where('completada',TRUE)->count();
    }

    public function retorna_cartas_por_recomendante($id_recomendante, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_tipo_programa_pos($locale);

        return $this->where('id_recomendante', $id_recomendante)->where('completada', true)->join('users', 'users.id_user','cartas_recomendacoes.id_candidato')->join('programa_pos_mat', 'id_programa_pos', 'cartas_recomendacoes.programa_pretendido')->select('cartas_recomendacoes.id_recomendante', 'cartas_recomendacoes.id_candidato', 'cartas_recomendacoes.id_inscricao_pos', 'users.nome', 'programa_pos_mat.'.$nome_coluna)->orderBy('cartas_recomendacoes.created_at', 'desc');
    }

    public function retorna_cartas_para_reativar($id_recomendante, $id_inscricao_pos, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_tipo_programa_pos($locale);

        return $this->where('id_recomendante', $id_recomendante)->where('id_inscricao_pos', $id_inscricao_pos)->where('completada', true)->join('users', 'users.id_user','cartas_recomendacoes.id_candidato')->join('programa_pos_mat', 'id_programa_pos', 'cartas_recomendacoes.programa_pretendido')->select('cartas_recomendacoes.id_recomendante', 'cartas_recomendacoes.id_candidato', 'cartas_recomendacoes.id_inscricao_pos', 'users.nome', 'programa_pos_mat.'.$nome_coluna, 'cartas_recomendacoes.completada')->orderBy('cartas_recomendacoes.created_at', 'desc')->get();
    }

    public function retorna_carta_recomendacao($id_recomendante,$id_candidato,$id_inscricao_pos)
    {

        return $this->where("id_recomendante", $id_recomendante)->where('id_candidato',$id_candidato)->where("id_inscricao_pos", $id_inscricao_pos)->get()->first();

    }

    public function retorna_carta_recomendacao_antiga($id_recomendante,$id_candidato,$id_inscricao_pos)
    {

        return $this->where("id_recomendante", $id_recomendante)->where('id_candidato',$id_candidato)->where('id_inscricao_pos', '!=', $id_inscricao_pos)->get()->first();

    }

    public function retorna_carta_recomendacao_nao_enviadas($id_inscricao_pos)
    {

        return $this->select('id_recomendante')->where("id_inscricao_pos", $id_inscricao_pos)->where('completada', false)->distinct('id_recomendante')->get()->pluck('id_recomendante');

    }

    public function inicia_carta_candidato($id_candidato, $id_inscricao_pos, $email_contatos_recomendantes)
    {
        
        $cartas_inicializadas = $this->select('id')->where('id_candidato', $id_candidato)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');

        if (count($cartas_inicializadas) == 0) {

            for ($i=0; $i < count($email_contatos_recomendantes); $i++) { 
                        
                $nova_carta_recomendacao = new CartaRecomendacao();

                $escolhas_candidato = new EscolhaCandidato();

                $acha_recomendante = new User();

                $nova_carta_recomendacao->id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

                $nova_carta_recomendacao->id_candidato = $id_candidato;

                $nova_carta_recomendacao->programa_pretendido = $escolhas_candidato->retorna_escolha_candidato($id_candidato, $id_inscricao_pos)->programa_pretendido;

                $nova_carta_recomendacao->id_inscricao_pos = $id_inscricao_pos;

                $nova_carta_recomendacao->save();
            }
        }

        if (count($cartas_inicializadas) == 1 or count($cartas_inicializadas) == 2 ) {
           
           $id_carta_recomendacoes = $this->select('id')->where('id_candidato', $id_candidato)->where('id_inscricao_pos',$id_inscricao_pos)->where('completada',false)->pluck('id');

           for ($i=0; $i < count($id_carta_recomendacoes); $i++) { 
               
                $acha_recomendante = new User();

                $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;
                
                DB::table('cartas_recomendacoes')->where('id', $id_carta_recomendacoes[$i])->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_recomendante' => $novo_id_recomendante, 'updated_at' => date('Y-m-d H:i:s')]);
            }

            
            for ($j=0; $j < count($email_contatos_recomendantes) - count($cartas_inicializadas); $j++) { 
                
                $nova_carta_recomendacao = new CartaRecomendacao();

                $escolhas_candidato = new EscolhaCandidato();

                $nova_carta_recomendacao->id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[($j+count($cartas_inicializadas))])->id_user;

                $nova_carta_recomendacao->id_candidato = $id_candidato;

                $nova_carta_recomendacao->programa_pretendido = $escolhas_candidato->retorna_escolha_candidato($id_candidato, $id_inscricao_pos)->programa_pretendido;

                $nova_carta_recomendacao->id_inscricao_pos = $id_inscricao_pos;

                $nova_carta_recomendacao->save();
            }
        }

        if (count($cartas_inicializadas) == 3) {

           $id_carta_recomendacoes = $this->select('id')->where('id_candidato', $id_candidato)->where('id_inscricao_pos',$id_inscricao_pos)->where('completada',false)->pluck('id');


           for ($i=0; $i < count($email_contatos_recomendantes); $i++) {        
                $acha_recomendante = new User();

                $novo_id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

               DB::table('cartas_recomendacoes')->where('id', $id_carta_recomendacoes[$i])->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update(['id_recomendante' => $novo_id_recomendante, 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }
    }
}
