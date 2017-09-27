<?php

namespace Posmat\Models;

use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class ConfiguraInscricaoPos extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $primaryKey = 'id_inscricao_pos';

    protected $table = 'configura_inscricao_pos';

    protected $fillable = [ 
        'inicio_inscricao', 
        'fim_inscricao',
        'prazo_carta',
        'programa',
        'edital',
        'id_coordenador',
    ];

    public function retorna_lista_para_relatorio()
    {
        $lista_relatorio = $this->orderBy('id_inscricao_pos','desc')->paginate(5);

        return $lista_relatorio;

    }

    public function retorna_inscricao_ativa()
    {
        $inscricao_pos_ativa = $this->get()->sortByDesc('id_inscricao_pos')->first();

        return $inscricao_pos_ativa;

    }

    public function retorna_periodo_inscricao()
    {

        if (is_null($this->retorna_inscricao_ativa())){
            $data_inicio = '3000-01-01';
        }else{
            $inicio = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->inicio_inscricao);
            $fim = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->fim_inscricao);
            
            $data_inicio = $inicio->format('Y-m-d');
            $data_fim = $fim->format('Y-m-d');    
        }

        $data_hoje = (new Carbon())->format('Y-m-d');
        


        if ($data_hoje >= $data_inicio && $data_hoje <= $data_fim) {
            return $periodo_inscricao = $inicio->format('d/m/Y')." à ".$fim->format('d/m/Y');
        }

        if ($data_hoje < $data_inicio) {
            return $periodo_inscricao = "A inscrição não está aberta";
        }

        if ($data_hoje > $data_fim) {
            return $periodo_inscricao = "Inscrições encerradas.";
        }
    }

    public function autoriza_inscricao()
    {
        $inicio = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->inicio_inscricao);
        $fim = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->fim_inscricao);

        $data_inicio = $inicio->format('Y-m-d');
        $data_fim = $fim->format('Y-m-d');

        $data_hoje = (new Carbon())->format('Y-m-d');

        if ($data_hoje >= $data_inicio && $data_hoje <= $data_fim) {
            return true;
        }else{
            return false;
        }
    }

    public function autoriza_configuracao_inscricao($nova_inscricao_inicio)
    {
        $inicio = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->inicio_inscricao);
        $fim = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->fim_inscricao);

        $data_inicio = $inicio->format('Y-m-d');
        $data_fim = $fim->format('Y-m-d');

        if ($nova_inscricao_inicio > $data_fim) {
            return true;
        }else{
            return false;
        }
    }

    public function ira_ano_semestre()
    {    
        $date = new Carbon();
        $mes = $date->format('m');
        $ano = $date->format('y');
    
        if ($mes < 7) {
            $ano_semestre_ira = "02/".($ano-1);
        }else{
            $ano_semestre_ira = "01/".$ano;
        }

        return $ano_semestre_ira;
    }

    
}
