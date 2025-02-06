<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DadosCoordenadorPos extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'dados_coordenador_pos';

    protected $fillable = [
        'nome_coordenador',
        'tratamento',
    ];

    public function retorna_dados_coordenador_atual()
    {

        return $this->orderBy('created_at', 'DESC')->get()->first();

    }
}
