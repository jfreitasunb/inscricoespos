<?php

namespace InscricoesPos\Http\Controllers\Recomendante;

use Auth;
use DB;
use Mail;
use Session;
use PDF;
use File;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaMotivacao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DadoPessoalCandidato;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\DadoAcademico;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\DadoPessoalRecomendante;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\Documento;
use InscricoesPos\Notifications\NotificaRecomendante;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\RelatorioController;
use InscricoesPos\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use InscricoesPos\Http\Requests;
use Illuminate\Support\Facades\Response;

/**
* Classe para manipulação do recomendante.
*/
class CartasAnterioresController extends RecomendanteController
{

	public function getCartasAnteriores()
	{
		$user = $this->SetUser();
		
		$id_prof = $user->id_user;

		$locale_recomendante = Session::get('locale');

		switch ($locale_recomendante) {
            case 'en':
                $nome_coluna = 'tipo_programa_pos_en';
                break;

            case 'es':
                $nome_coluna = 'tipo_programa_pos_es';
                break;
            
            default:
                $nome_coluna = 'tipo_programa_pos_ptbr';
                break;
        }

		$indicacoes = new CartaRecomendacao;

		$indicacoes_anteriores = $indicacoes->retorna_cartas_por_recomendante($id_prof, $locale_recomendante)->paginate(10);

		return view('templates.partials.recomendante.cartas_anteriores', compact('indicacoes_anteriores', 'nome_coluna'));
	}

	public function GeraCartasAnteriores()
	{
		
		$user = $this->SetUser();
		
		$id_prof = $user->id_user;

		$locale_recomendante = Session::get('locale');

		// $locais_arquivos_carta_enviadas = public_path("/relatorios/cartas_enviadas/");
		
		// File::isDirectory($locais_arquivos_carta_enviadas) or File::makeDirectory($locais_arquivos_carta_enviadas,077,true,true);

		$id_inscricao_pos = (int) $_GET['id_inscricao_pos'];
		
		$id_aluno = (int) $_GET['id_aluno'];

		$carta = new RelatorioController;

		$dados_para_carta_enviada['nome_candidato'] = $carta->ConsolidaDadosPessoais($id_aluno)['nome'];

		$dados_para_carta_enviada['programa_pretendido'] = $carta->ConsolidaEscolhaCandidato($id_aluno,$id_inscricao_pos, $locale_recomendante)['programa_pretendido'];

		$carta_enviada = $carta->ConsolidaCartaPorRecomendante($id_prof,$id_aluno,$id_inscricao_pos);

		// $nome_arquivos_carta_envidada = $locais_arquivos_carta_enviadas.bin2hex(openssl_random_pseudo_bytes(15)).'.pdf';

		
		$pdf = PDF::loadView('templates.partials.recomendante.pdf_carta_enviada', compact('dados_para_carta_enviada','carta_enviada'));
      	
      	return $pdf->stream($dados_para_carta_enviada['nome_candidato'].'.pdf',array('Attachment'=> 1));

	}
}