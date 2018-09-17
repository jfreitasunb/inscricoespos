<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ConfiguraInicioPrograma extends FuncoesModels
{
    use SoftDeletes;

    protected $primaryKey = 'id_inicio_programa';

    protected $table = 'configura_inicio_programa';

    protected $fillable = [
        'id_inscricao_pos',
        'mes_inicio',
        'id_coordenador',
        'deleted_at',
    ];

}
