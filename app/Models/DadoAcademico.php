<?php

namespace Monitoriamat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DadoAcademico extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'dados_academicos';

    protected $fillable = [
        'ira',
        'monitor_convidado',
        'nome_professor' ,
        'curso_graduacao',
    ];

public function retorna_dados_academicos($id_user)
    {
        $dados_academicos = $this->find($id_user);

        return $dados_academicos;

    }
}