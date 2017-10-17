<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DadoAcademico extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'dados_academicos';

    protected $fillable = [
        'curso_graduacao',
        'tipo_curso_graduacao',
        'instituicao_graduacao',
        'ano_conclusao_graduacao',
        'curso_pos',
        'tipo_curso_pos',
        'instituicao_pos',
        'ano_conclusao_pos',
    ];

public function retorna_dados_academicos($id_user)
    {
        $dados_academicos = $this->find($id_user);

        return $dados_academicos;

    }
}