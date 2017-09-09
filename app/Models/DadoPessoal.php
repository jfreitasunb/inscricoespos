<?php

namespace Monitoriamat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DadoPessoal extends Model
{
    protected $primaryKey = 'id_user';

    protected $table = 'dados_pessoais';

    protected $fillable = [
        'nome',
        'numerorg',
        'emissorrg', 
        'cpf',
        'endereco',
        'cidade',
        'cep',
        'estado',
        'telefone',
        'celular',
    ];

public function retorna_dados_pessoais($id_user)
    {
        $dados_pessoais = $this->find($id_user);

        return $dados_pessoais;

    }

}
