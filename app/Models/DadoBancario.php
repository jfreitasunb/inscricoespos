<?php

namespace Monitoriamat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DadoBancario extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'dados_bancarios';

    protected $fillable = [
        'nome_banco',
        'numero_banco', 
        'agencia_bancaria',
        'numero_conta_corrente',
    ];

public function retorna_dados_bancarios($id_user)
    {
        $dados_bancarios = $this->find($id_user);

        return $dados_bancarios;

    }

}