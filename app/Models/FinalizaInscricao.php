<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class FinalizaInscricao extends FuncoesModels
{
    protected $primaryKey = 'id_candidato';

    protected $table = 'finaliza_inscricao';

    protected $fillable = [
    ];

    public function retorna_inscricao_finalizada($id_candidato,$id_inscricao_pos)
    {
        $finalizou_inscricao = $this->select('finalizada')->where("id_candidato", $id_candidato)->where("id_inscricao_pos", $id_inscricao_pos)->get();

        if (count($finalizou_inscricao)>0 and $finalizou_inscricao[0]['finalizada']) {
        	return TRUE;
        }else{
        	return FALSE;
        }

    }

    public function retorna_usuarios_relatorio_individual($id_inscricao_pos, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_tipo_programa_pos($locale);

        $homologadas = new HomologaInscricoes;

        $inscricoes_homologadas = $homologadas->retorna_inscricoes_homologadas($id_inscricao_pos);

        if (sizeof($inscricoes_homologadas) == 0) {
            return $this->where('finaliza_inscricao.id_inscricao_pos', $id_inscricao_pos)->where('finaliza_inscricao.finalizada', true)->join('dados_pessoais_candidato', 'dados_pessoais_candidato.id_candidato','finaliza_inscricao.id_candidato')->join('users', 'users.id_user', 'finaliza_inscricao.id_candidato')->join('escolhas_candidato', 'escolhas_candidato.id_candidato', 'dados_pessoais_candidato.id_candidato')->where('escolhas_candidato.id_inscricao_pos', $id_inscricao_pos)->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->select('finaliza_inscricao.id_candidato', 'finaliza_inscricao.id_inscricao_pos','users.nome', 'users.email', 'programa_pos_mat.id_programa_pos', 'programa_pos_mat.'.$nome_coluna)->orderBy('escolhas_candidato.programa_pretendido' , 'desc')->orderBy('users.nome','asc');
        }else{

            $dados_auxiliares = new AuxiliaSelecao();

            if (sizeof($dados_auxiliares->retorna_inscricoes_auxiliares($id_inscricao_pos)) == 0){
                
                return $homologadas->retorna_dados_homologados($id_inscricao_pos, $locale);

            }else{

                return $dados_auxiliares->retorna_dados_auxiliares_relatorio($id_inscricao_pos, $locale);
            }

            
        }

        
    }

    public function retorna_usuarios_relatorios($id_inscricao_pos)
    {
        $homologadas = new HomologaInscricoes;

        $inscricoes_homologadas = $homologadas->retorna_inscricoes_homologadas($id_inscricao_pos);
        
        if (sizeof($inscricoes_homologadas) == 0) {
            
            return $this->where('id_inscricao_pos', $id_inscricao_pos)->where('finalizada', true)->get();

        }else{

            $dados_auxiliares = new AuxiliaSelecao();

            if (sizeof($dados_auxiliares->retorna_inscricoes_auxiliares($id_inscricao_pos)) == 0){
                
                return $homologadas->retorna_dados_homologados($id_inscricao_pos, $locale);

            }else{

                return $dados_auxiliares->retorna_dados_auxiliares_relatorio($id_inscricao_pos, $locale);
            }
        }
    }

    public function retorna_usuario_inscricao_finalizada($id_inscricao_pos, $id_candidato, $locale)
    {
        $nome_coluna = $this->define_nome_coluna_tipo_programa_pos($locale);

        return $this->where('finaliza_inscricao.id_inscricao_pos', $id_inscricao_pos)->where('finaliza_inscricao.finalizada', true)->where('finaliza_inscricao.id_candidato', $id_candidato)->join('users', 'users.id_user','finaliza_inscricao.id_candidato')->join('configura_inscricao_pos','configura_inscricao_pos.id_inscricao_pos', 'finaliza_inscricao.id_inscricao_pos')->join('escolhas_candidato', 'escolhas_candidato.id_candidato', 'users.id_user')->where('escolhas_candidato.id_inscricao_pos', $id_inscricao_pos)->join('programa_pos_mat', 'id_programa_pos', 'escolhas_candidato.programa_pretendido')->select('finaliza_inscricao.id', 'finaliza_inscricao.id_candidato', 'finaliza_inscricao.id_inscricao_pos', 'finaliza_inscricao.finalizada', 'configura_inscricao_pos.edital', 'users.nome','programa_pos_mat.'.$nome_coluna)->get()->first();
    }

    public function retorna_dados_inscricao_finalizada($id_inscricao_pos, $id_candidato)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->where('id_candidato', $id_candidato)->get()->first();
    }

    public function retorna_se_finalizou($id_candidato, $id_inscricao_pos)
    {
        return $this->select('finalizada')->where('id_candidato',$id_candidato)->where('id_inscricao_pos',$id_inscricao_pos)->value('finalizada');
    }

    public function retorna_total_inscricoes_finalizadas($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos',$id_inscricao_pos)->where('finalizada', TRUE)->count();
    }
}
