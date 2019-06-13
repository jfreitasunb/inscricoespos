<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ConfiguraEnvioDocumentosMatricula extends FuncoesModels
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    protected $table = 'configura_envio_documentos_matricula';

    protected $fillable = [
        'id_inscricao_pos',
        'inicio_envio_documentos', 
        'fim_envio_documentos',
        'id_coordenador',
    ];

    public function libera_tela_confirmacao($id_inscricao_pos)
    {
        $periodos_confirmacao = $this->retorna_meses_para_inicio($id_inscricao_pos);
        
        $data_hoje = (new Carbon())->format('Y-m-d');

        $liberar_tela = false;

        foreach ($periodos_confirmacao as $periodo) {
            
            $prazo = Carbon::createFromFormat('Y-m-d', $periodo->prazo_confirmacao);

            if ($data_hoje <= $prazo) {
                $liberar_tela = true;
            }else{
                $liberar_tela = false;
            }
        }
        return $liberar_tela; 
    }

    public function limpa_configuracoes_anteriores($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->delete();
    }

}
