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
        'id_candidato',
        'id_inscricao_pos',
        'id_programa_pretendido',
        'tipo_arquivo',
        'nome_arquivo',
        'arquivo_recebido',
        'arquivo_final',
    ];

    
}
