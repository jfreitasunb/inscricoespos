<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $primaryKey = 'id_candidato';

    protected $table = 'arquivos_enviados';

    protected $fillable = [
        'nome_arquivo',
        'tipo_arquivo',
    ];

    public function retorna_arquivo_enviado($id_candidato)
    {
    	return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->orderBy('created_at','desc')->first();
    }

    public function retorna_historico($id_candidato,$id_inscricao_pos)
    {
        if (!is_null($this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Histórico')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first())) {
            
            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Histórico')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
        }else{

            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Histórico')->orderBy('created_at','desc')->first();
        }
    }

    public function retorna_documento($id_candidato,$id_inscricao_pos)
    {   
        if (!is_null($this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Documentos')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first())) {
            
            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Documentos')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
        }else{

            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Documentos')->orderBy('created_at','desc')->first();

        }
    }

    public function retorna_arquivo_edital_atual($id_candidato,$id_inscricao_pos, $tipo_arquivo)
    {   
        
        return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo', $tipo_arquivo)->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
    }

    public function retorna_comprovante_proficiencia($id_candidato,$id_inscricao_pos)
    {   
        if (!is_null($this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Proficiência Inglês')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first())) {
            
            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Proficiência Inglês')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
        }else{

            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Proficiência Inglês')->orderBy('created_at','desc')->first();

        }
    }

    public function retorna_projeto($id_candidato,$id_inscricao_pos)
    {   
        if (!is_null($this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Projeto')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first())) {
            
            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Projeto')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
        }else{

            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Projeto')->orderBy('created_at','desc')->first();

        }
    }

    public function retorna_existencia_documentos($id_candidato, $id_inscricao_pos)
    {
        return !is_null($this->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->get());
    }

    public function atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, $tipo_arquivo)
    {
        DB::table('arquivos_enviados')
            ->where('id_candidato', $id_candidato)
            ->where('id_inscricao_pos', $id_inscricao_pos)
            ->where('tipo_arquivo', $tipo_arquivo)
            ->update(['updated_at' => date('Y-m-d H:i:s')]);
    }

    public function retorna_arquivo_para_limpeza()
    {
        return $this->where('removido', FALSE)->orderBy('created_at', 'ASC')->get();
    }
}
