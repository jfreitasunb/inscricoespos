<?php

namespace Monitoriamat\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{

    protected $fillable = ['nome'];

    public $timestamps = false;

    public function cidades()
    {
        return $this->hasMany('Monitoriamat\Models\Cidade');
    }

}
