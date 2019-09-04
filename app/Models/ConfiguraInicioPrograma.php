<?php

namespace InscricoesPos\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ConfiguraInicioPrograma extends FuncoesModels
{
    use SoftDeletes;

    protected $primaryKey = 'id_inicio_programa';

    protected $table = 'configura_inicio_programa';

    protected $fillable = [
        'id_inscricao_pos',
        'prazo_confirmacao',
        'mes_inicio',
        'id_coordenador',
        'programa_para_confirmar',
        'deleted_at',
    ];

    public function retorna_configuracao_confirmacao($id_inscricao_pos)
    {
        return is_null($this->where('id_inscricao_pos', $id_inscricao_pos)->value('prazo_confirmacao'));
    }

    public function retorna_meses_para_inicio($id_inscricao_pos)
    {
        return $this->where('id_inscricao_pos', $id_inscricao_pos)->orderBy('prazo_confirmacao')->get();
    }

    public function retorna_se_precisam_confirmar_mes($id_inscricao_pos, $id_programa_pos)
    {   
        $confirmacoes = $this->where('id_inscricao_pos', $id_inscricao_pos)->get();

        foreach ($confirmacoes as $precisa_confirmar) {
            if (is_null($precisa_confirmar->programa_para_confirmar)) {
                $todos = true;
            }else{
                $todos = false;
            }
        }

        if (!$todos) {

            $programa_confirmar = $this->where('programa_para_confirmar', $id_programa_pos)->where('id_inscricao_pos', $id_inscricao_pos)->value('programa_para_confirmar');

            if (is_null($programa_confirmar)) {
                return false;
            }else{
                return true;
            }
        }else{
            return $todos;
        }
        
    }

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
