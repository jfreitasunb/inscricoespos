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

    public function retorna_se_arquivo_foi_enviado($id_candidato, $id_inscricao_pos, $id_programa_pretendido, $tipo_arquivo)
    {
        $temp = $this->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('id_programa_pretendido', $id_programa_pretendido)->where('tipo_arquivo', $tipo_arquivo)->get()->first();

        if (is_null($temp)) {
            return null;
        }else{
            return $temp->nome_arquivo;
        }
    }

    public function atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, $id_programa_pretendido, $tipo_arquivo, $arquivo_recebido)
    {
        DB::table('documentos_matricula')
            ->where('id_candidato', $id_candidato)
            ->where('id_inscricao_pos', $id_inscricao_pos)
            ->where('id_programa_pretendido', $id_programa_pretendido)
            ->where('tipo_arquivo', $tipo_arquivo)
            ->update([
                'arquivo_recebido' => $arquivo_recebido,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    
}
