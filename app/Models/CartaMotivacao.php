<?php

namespace Posmat\Models;

use Illuminate\Database\Eloquent\Model;

class CartaMotivacao extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'carta_motivacaos';

    protected $fillable = [
        'motivacao',
    ];

    public function retorna_carta_motivacao($id_user,$id_inscricao_pos)
    {
        $carta_motivacao = $this->where("id_user", $id_user)->where("id_inscricao_pos", $id_inscricao_pos)->get();

        return $carta_motivacao;

    }
}
