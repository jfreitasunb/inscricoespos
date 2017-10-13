<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class ContatoRecomendante extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'contatos_recomendantes';

    protected $fillable = [
        'id_recomendante',
        'id_inscricao_pos',
    ];

    public function retorna_recomendante_candidato($id_user,$id_inscricao_pos)
    {
        $escolheu_monitoria = $this->where("id_user", $id_user)->where("id_inscricao_pos", $id_inscricao_pos)->get();

        return $escolheu_monitoria;

    }
}
