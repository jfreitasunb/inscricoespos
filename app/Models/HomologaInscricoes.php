<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;

class HomologaInscricoes extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'homologa_inscricoes';

    protected $fillable = [
        'id_candidato',
        'id_inscricao_pos',
        'programa_pretendido',
        'homologar',
        'id_coordenador',
    ];

}
