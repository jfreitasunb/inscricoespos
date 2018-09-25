<?php

namespace InscricoesPos\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\ConfiguraInicioPrograma;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\HomologaInscricoes;
use InscricoesPos\Models\CandidatosSelecionados;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use League\Csv\Writer;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\RelatorioController;
use Illuminate\Foundation\Auth\RegistersUsers;
use UrlSigner;
use URL;

/**
* Classe para visualização da página inicial.
*/
class StatusConfirmaParticipacaoController extends CoordenadorController
{

	public function getStatusCandidatosSelecionados()
	{
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();

        $selecionados = new CandidatosSelecionados;

        $candidatos_selecionados = $selecionados->retorna_dados_candidatos_selecionados($relatorio_disponivel->id_inscricao_pos, $this->locale_default);

        $array_meses[1]  = 'Janeiro';
        $array_meses[2]  = 'Fevereiro';
        $array_meses[3]  = 'Março';
        $array_meses[4]  = 'Abril';
        $array_meses[5]  = 'Maio';
        $array_meses[6]  = 'Junho';
        $array_meses[7]  = 'Julho';
        $array_meses[8]  = 'Agosto';
        $array_meses[9]  = 'Setembro';
        $array_meses[10] = 'Outubro';
        $array_meses[11] = 'Novembro';
        $array_meses[12] = 'Dezembro';

        foreach ($candidatos_selecionados as $selecionado) {

            if (is_null($selecionado->inicio_no_programa)) {
                $mes_candidato[$selecionado->id_candidato] = "Não informado";
            }else{
                $mes = ConfiguraInicioPrograma::find($selecionado->inicio_no_programa)->mes_inicio;
                $mes_candidato[$selecionado->id_candidato] = $array_meses[$mes];
            }
        }

        $cabecalho_csv = [
            0 => 'Nome',
            1 => 'E-mail',
            2 => 'Programa',
            3 => 'Confirmou Presença?',
            4 => 'Mês de Início',
        ];

        dd($cabecalho_csv);
        
        $relatorio_csv = Writer::createFromPath($locais_arquivos['local_relatorios'].$locais_arquivos['arquivo_relatorio_csv'], 'w+');
    

        $relatorio_csv->insertOne();

        $relatorio_csv->insertOne($linha_arquivo);

      	return view('templates.partials.coordenador.status_selecionados', compact('relatorio_disponivel','candidatos_selecionados', 'mes_candidato'));
	}
}