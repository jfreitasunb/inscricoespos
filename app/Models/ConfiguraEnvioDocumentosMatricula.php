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

    public function foi_configurado_envio_documentos($id_inscricao_pos)
    {
        return is_null($this->where('id_inscricao_pos', $id_inscricao_pos)->get()->first());
    }

    public function libera_tela_documento_matricula($id_inscricao_pos)
    {
        $periodo_envio_documentos = $this->where('id_inscricao_pos', $id_inscricao_pos)->get()->first();

        if (is_null($periodo_envio_documentos)) {
            return false;
        }
        
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

    public function libera_tela_documento_matricula_coordenador($id_inscricao_pos)
    {
        $periodo_envio_documentos = $this->where('id_inscricao_pos', $id_inscricao_pos)->get()->first();

        if (is_null($periodo_envio_documentos)) {
            return false;
        }
        
        $data_hoje = (new Carbon())->format('Y-m-d');
            
        $inicio_prazo = Carbon::createFromFormat('Y-m-d', $periodo_envio_documentos->inicio_envio_documentos)->format('Y-m-d');

        $fim_prazo = Carbon::createFromFormat('Y-m-d', $periodo_envio_documentos->fim_envio_documentos)->format('Y-m-d');

        if (($data_hoje >= $inicio_prazo)) {
        
            $liberar_tela = true;
        }
        
        return $liberar_tela; 
    }
    public function retorna_inicio_prazo_envio_documentos($id_inscricao_pos)
    {
        $temp = $this->where('id_inscricao_pos', $id_inscricao_pos)->get()->first();

        if (!is_null($temp)) {
            
            return Carbon::createFromFormat('Y-m-d', $temp->inicio_envio_documentos)->format('Y-m-d');
        }else{

            return Carbon::createFromFormat('Y-m-d', '2000-01-01')->format('Y-m-d');
        }
        
    }

    public function retorna_fim_prazo_envio_documentos($id_inscricao_pos)
    {   
        $temp = $this->where('id_inscricao_pos', $id_inscricao_pos)->get()->first();
        
        if (!is_null($temp)) {

            return Carbon::createFromFormat('Y-m-d', $temp->fim_envio_documentos)->format('Y-m-d');
        }else{
            
            return Carbon::createFromFormat('Y-m-d', '2000-01-02')->format('Y-m-d');
        }
    }

    public function retorna_periodo_envio_documentos_matricula($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->get();
    }
}
