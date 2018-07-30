<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomologaInscricoes extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $table = 'homologa_inscricoes';

    protected $fillable = [
        'id_candidato',
        'id_inscricao_pos',
        'programa_pretendido',
        'homologar',
        'id_coordenador',
        'deleted_at',
    ];

    public function retorna_inscricoes_homologadas($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->where('homologar', 'True')->get();
    }

    public function limpa_homologacoes_anteriores($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->delete();
    }
}
