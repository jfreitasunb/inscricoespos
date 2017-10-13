<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class ContatoRecomendante extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'escolhas_candidato';

    protected $fillable = [
        'id_recomendante',
        'id_inscricao_pos',
    ];
}
