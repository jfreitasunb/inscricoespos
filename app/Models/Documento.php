<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'arquivos_enviados';

    protected $fillable = [
        'nome_arquivo',
        'tipo_arquivo',
    ];

    public function retorna_arquivo_enviado($id_user)
    {
    	return $this->select('nome_arquivo')->where('id_user',$id_user)->orderBy('created_at','desc')->first();
    }

    public function retorna_historico($id_user,$id_inscricao_pos)
    {
        if (!is_null($this->select('nome_arquivo')->where('id_user',$id_user)->where('tipo_arquivo','Histórico')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first())) {
            
            return $this->select('nome_arquivo')->where('id_user',$id_user)->where('tipo_arquivo','Histórico')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
        }else{

            return $this->select('nome_arquivo')->where('id_user',$id_user)->where('tipo_arquivo','Histórico')->orderBy('created_at','desc')->first();
        }
    }

    public function retorna_documento($id_user,$id_inscricao_pos)
    {   
        if (!is_null($this->select('nome_arquivo')->where('id_user',$id_user)->where('tipo_arquivo','Documentos')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first())) {
            
            return $this->select('nome_arquivo')->where('id_user',$id_user)->where('tipo_arquivo','Documentos')->where('id_inscricao_pos',$id_inscricao_pos)->orderBy('created_at','desc')->first();
        }else{

            return $this->select('nome_arquivo')->where('id_user',$id_user)->where('tipo_arquivo','Documentos')->orderBy('created_at','desc')->first();

        }
    }
}
