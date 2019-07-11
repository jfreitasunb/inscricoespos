<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class ConfiguraEnvioDocumentosMatricula extends FuncoesModels
{
    protected $primaryKey = 'id';

    protected $table = 'configura_envio_documentos_matricula';

    protected $fillable = [
        'id_inscricao_pos',
        'inicio_envio_documentos', 
        'fim_envio_documentos',
        'id_coordenador',
    ];

    public function libera_tela_documento_matricula($id_inscricao_pos)
    {
        $periodo_envio_documentos = $this->where('id_inscricao_pos', $id_inscricao_pos)->get()->first();
        
        $data_hoje = (new Carbon())->format('Y-m-d');
            
        $inicio_prazo = Carbon::createFromFormat('Y-m-d', $periodo_envio_documentos->inicio_envio_documentos)->format('Y-m-d');

        $fim_prazo = Carbon::createFromFormat('Y-m-d', $periodo_envio_documentos->fim_envio_documentos)->format('Y-m-d');

        if (($data_hoje >= $inicio_prazo) AND ( $data_hoje <= $fim_prazo)) {
        
            $liberar_tela = true;
        }else{
        
            $liberar_tela = false;
        }
        
        return $liberar_tela; 
    }

    public function retorna_prazo_envio_documentos($id_inscricao_pos)
    {
        return Carbon::createFromFormat('Y-m-d', $this->where('id_inscricao_pos', $id_inscricao_pos)->get()->first()->fim_envio_documentos)->format('Y-m-d');
    }
}
