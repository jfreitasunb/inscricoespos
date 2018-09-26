<?php

namespace InscricoesPos\Models;

use DB;
use Session;
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
        'data_homologacao',
        'data_divulgacao_resultado',
        'programa',
        'edital',
        'id_coordenador',
    ];

    public function retorna_lista_para_relatorio()
    {

        return $this->orderBy('id_inscricao_pos','desc')->paginate(5);
    }

     public function retorna_edital_vigente()
    {

        return $this->orderBy('id_inscricao_pos','desc')->get()->first();

    }

    public function retorna_inscricao_ativa()
    {

        return $this->get()->sortByDesc('id_inscricao_pos')->first();

    }

    public function define_texto_inscricao()
    {

        if (!is_null($this->retorna_inscricao_ativa())){
            $programas = explode('_', $this->retorna_inscricao_ativa()->programa);

            
                if (sizeof($programas) > 1) {
                    return $texto_inscricao_pos = 'dois_programas';
                }else{
                    if ($programas[0] == 1) {
                    return $texto_inscricao_pos = 'inscricao_mestrado';
                }

                    if ($programas[0] == 2) {
                    return $texto_inscricao_pos = 'inscricao_doutorado';
                    }
                }

                

        }
    }

    public function retorna_periodo_inscricao()
    {
        Session::get('locale');
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
            if (Session::get('locale') == 'en') {
                return $periodo_inscricao = $inicio->format('m/d/Y').trans('mensagens_gerais.to').$fim->format('m/d/Y');
            }else{
                return $periodo_inscricao = $inicio->format('d/m/Y').trans('mensagens_gerais.to').$fim->format('d/m/Y');
            }
            
        }

        if ($data_hoje < $data_inicio) {
            return $periodo_inscricao = trans('mensagens_gerais.inscricao_nao_iniciada');
        }

        if ($data_hoje > $data_fim) {
            return $periodo_inscricao = trans('mensagens_gerais.inscricao_encerrada');
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

     public function autoriza_homologacao()
    {
        $inicio = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->inicio_inscricao);
        $fim = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->fim_inscricao);

        $data_inicio = $inicio->format('Y-m-d');
        $data_fim = $fim->format('Y-m-d');

        $data_hoje = (new Carbon())->format('Y-m-d');

        if ($data_hoje >= $data_fim) {
            return true;
        }else{
            return false;
        }
    }


    public function visualiza_status_carta()
    {
        $inicio = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->inicio_inscricao);
        $fim = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->fim_inscricao)->addDays(20);

        $data_inicio = $inicio->format('Y-m-d');
        $data_fim = $fim->format('Y-m-d');

        $data_hoje = (new Carbon())->format('Y-m-d');

        if ($data_hoje >= $data_inicio && $data_hoje <= $data_fim) {
            return true;
        }else{
            return false;
        }
    }

    public function autoriza_carta()
    {
        $prazo = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->prazo_carta);

        $data_prazo_carta = $prazo->format('Y-m-d');

        $data_hoje = (new Carbon())->format('Y-m-d');

        if ($data_hoje > $data_prazo_carta) {
            return false;
        }else{
            return true;
        }
    }

    public function autoriza_configuracao_inscricao($nova_inscricao_inicio)
    {

        if (!is_null($this->retorna_inscricao_ativa())) {
            
            $inicio = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->inicio_inscricao);
            $fim = Carbon::createFromFormat('Y-m-d', $this->retorna_inscricao_ativa()->fim_inscricao);

            $data_inicio = $inicio->format('Y-m-d');
            $data_fim = $fim->format('Y-m-d');

            if ($nova_inscricao_inicio > $data_fim) {
                return true;
            }else{
                return false;
            }
        }else{

            return true;
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
