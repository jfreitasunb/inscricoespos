<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomologaInscricoes extends Model
{
    use SoftDeletes;
    
    protected $primaryKey = 'id';

    protected $table = 'homologa_inscricoes';

    protected $fillable = [
        'id_candidato',
        'id_inscricao_pos',
        'programa_pretendido',
        'homologar',
        'id_coordenador',
        'deleted_at',
    ];

}
