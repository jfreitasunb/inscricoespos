<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class CartaMotivacao extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'carta_motivacoes';

    protected $fillable = [
        'motivacao',
    ];

    public function retorna_carta_motivacao($id_candidato,$id_inscricao_pos)
    {
     
        return $this->where("id_candidato", $id_candidato)->where("id_inscricao_pos", $id_inscricao_pos)->get()->first();

    }
}
