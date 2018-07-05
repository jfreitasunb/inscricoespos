<?php

namespace Posmat\Http\Controllers\Recomendante;

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
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\CartaMotivacao;
use Posmat\Models\ProgramaPos;
use Posmat\Models\DadoPessoalCandidato;
use Posmat\Models\Formacao;
use Posmat\Models\Estado;
use Posmat\Models\DadoAcademico;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\DadoPessoalRecomendante;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\FinalizaInscricao;
use Posmat\Models\Documento;
use Posmat\Notifications\NotificaRecomendante;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\RelatorioController;
use Posmat\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Posmat\Http\Requests;
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