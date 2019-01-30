<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuxiliaSelecao extends FuncoesModels
{

    protected $primaryKey = 'id';

    protected $table = 'auxilia_selecao';

    protected $fillable = [
        'id_candidato',
        'id_inscricao_pos',
        'programa_pretendido',
        'desclassificado',
        'id_coordenador',
    ];
}
