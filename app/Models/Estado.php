<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{

    protected $fillable = ['nome'];

    public $timestamps = false;

    public function cidades()
    {
        return $this->hasMany('Posmat\Models\Cidade');
    }

    public function retorna_nome_estados_por_id($id_pais, $id_estado)
    {
    	return $this->select('name')->where('id_state',$id_estado)->where('country_id', $id_pais)->get()->first()->name;
    }

}
