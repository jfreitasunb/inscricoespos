<?php

namespace Posmat\Models;

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
        'data_nascimento',
        'numerorg',
        'endereco',
        'cep',
        'pais',
        'estado',
        'cidade',
        'celular',
    ];

    public function retorna_dados_pessoais($id_user)
    {
        
        return $this->find($id_user);

    }

}
