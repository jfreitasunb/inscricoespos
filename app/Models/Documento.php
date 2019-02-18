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

    public function retorna_proficiencia($id_candidato,$id_inscricao_pos)
    {   
        if (!is_null($this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Proficiencia Inglês')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first())) {
            
            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Proficiencia Inglês')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
        }else{

            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Proficiencia Inglês')->orderBy('created_at','desc')->first();

        }
    }

    public function retorna_comprovante_ingles($id_candidato,$id_inscricao_pos)
    {   
        if (!is_null($this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Inglês')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first())) {
            
            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Inglês')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
        }else{

            return $this->select('nome_arquivo')->where('id_candidato',$id_candidato)->where('tipo_arquivo','Comprovante Inglês')->orderBy('created_at','desc')->first();

        }
    }
}
