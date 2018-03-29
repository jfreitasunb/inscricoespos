<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use File;
use ZipArchive;
use PDF;
use Imagick;
use Charts;
use Posmat\Http\Controllers\FPDFController;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Models\DadoPessoal;
use Posmat\Models\Paises;
use Posmat\Models\Formacao;
use Posmat\Models\Estado;
use Posmat\Models\Cidade;
use Posmat\Models\DadoRecomendante;
use Posmat\Models\DadoAcademico;
use Posmat\Models\Documento;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaMotivacao;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\AreaPosMat;
use Posmat\Models\ProgramaPos;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;
use League\Csv\Writer;
use Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GraficosController extends BaseController
{   
    private $locale_default = 'pt-br';

	public function index()
    {

        $user = Auth::user();
        
        $relatorio = new ConfiguraInscricaoPos();

        $relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $relatorio_para_grafico = new RelatorioController;

        $programas_disponiveis = explode("_", $relatorio_disponivel->retorna_inscricao_ativa()->programa);

        $nome_programa_pos = new ProgramaPos();

        foreach ($programas_disponiveis as $programa) {

        $programa_para_inscricao[$programa] = $nome_programa_pos->pega_programa_pos_mat($programa, $this->locale_default);
      
        $contagem[$programa_para_inscricao[$programa]] = $relatorio_para_grafico->ContaInscricoes($relatorio_disponivel->id_inscricao_pos, $programa);

        }

        $total_inscritos = array_sum($contagem);

        $inscritos_por_programa = Charts::create('pie', 'highcharts')
                ->title("Inscrições para o Edital ".$relatorio_disponivel->edital)
                ->labels(array_keys($contagem))
                ->values(array_values($contagem))
                ->dimensions(1000,500)
                ->responsive(true);


        if (array_key_exists("Doutorado", $contagem)) {

            $escolhas_candidato = new EscolhaCandidato;

            $areas_inscricoes = $escolhas_candidato->retorna_area_distintas($relatorio_disponivel->id_inscricao_pos);

            dd($areas_inscricoes);
            
            $candidatos_por_area_doutorado = Charts::multi('bar', 'material')
                ->title("Inscritos no Doutorado por área/Edital ".$relatorio_disponivel->edital)
                ->dimensions(0, 400) // Width x Height
                ->template("material")
                ->dataset('', array_values($contagem))
                ->labels(array_keys($contagem));

            $inscricao_doutorado = TRUE;

            return view('templates.partials.graficos.graficos_pos', compact('inscricao_doutorado','inscritos_por_programa','candidatos_por_area_doutorado'));
        }else{

            $inscricao_doutorado = FALSE;
            return view('templates.partials.graficos.graficos_pos', compact('inscricao_doutorado', 'inscritos_por_programa'));

        }
    }
}