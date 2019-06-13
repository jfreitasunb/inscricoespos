<?php

namespace InscricoesPos\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class DocumentoMatricula extends Model
{
    protected $primaryKey = 'id_candidato';

    protected $table = 'documentos_matricula';

    protected $fillable = [
        'nome_arquivo',
    ];

    
}
