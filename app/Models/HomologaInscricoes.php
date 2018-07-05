<?php

namespace Posmat;

use Illuminate\Database\Eloquent\Model;

class HomologaInscricoes extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'homologa_inscricoes';

    protected $fillable = [
        'id_candidato',
        'id_inscricao_pos',
        'programa_pretendido',
        'id_coordenador',
    ];

}
