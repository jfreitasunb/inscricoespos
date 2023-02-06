<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DisciplinaDestaque extends Model
{
    protected $primaryKey = 'id_candidato';

    protected $table = 'disciplinas_destaque';

    protected $fillable = [
        'nome_disciplina',
        'mencao',
    ];

    public function retorna_disciplinas_destaque($id_candidato, $id_inscricao_pos)
    {
        
        return $this->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->get();
    }
}
