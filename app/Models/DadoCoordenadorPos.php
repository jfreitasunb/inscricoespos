<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DadoCoordenadorPos extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'dados_coordenador_pos';

    protected $fillable = [
        'nome_coordenador',
        'tratamento',
    ];

    public function retorna_dados_coordenador_atual()
    {
        
        return $this->orderBy('created_at')->get()->first();

    }
}
