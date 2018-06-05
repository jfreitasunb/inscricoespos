<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DadoPessoalCandidato extends Model
{
    protected $primaryKey = 'id_candidato';

    protected $table = 'dados_pessoais_candidato';

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

    public function retorna_user_por_nome($nome_pesquisado)
    {
        return $this->where('nome', 'ILIKE', $nome_pesquisado.'%')->join('users', 'users.id_user', 'dados_pessoais.id_user')->select('users.id_user', 'dados_pessoais.nome', 'users.email', 'users.locale', 'users.user_type', 'users.ativo')->get();
    }

}
