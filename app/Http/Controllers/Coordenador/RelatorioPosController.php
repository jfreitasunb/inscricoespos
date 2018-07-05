<?php

namespace Posmat\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\Formacao;
use Posmat\Models\ProgramaPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\RelatorioController;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
* Classe para visualização da página inicial.
*/
class RelatorioPosController extends CoordenadorController
{

	public function getRelatorioPos()
	{

		return view('templates.partials.coordenador.relatorio_pos');
	}

	public function VerFichaIndividual($nome_pdf, $id_aluno_pdf)
	{

		$user = Auth::user();
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();


		$finalizacoes = new FinalizaInscricao;

		$inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->paginate(10);


		return view('templates.partials.coordenador.ficha_individual', compact('inscricoes_finalizadas', 'nome_pdf', 'id_aluno_pdf'));

	}

	public function getFichaInscricaoPorCandidato()
	{

		$user = Auth::user();
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();


		$finalizacoes = new FinalizaInscricao;

		if (session()->has('nome_pdf')) {
			$nome_pdf = session()->get('nome_pdf');
		}else{
			$nome_pdf = null;
		}

		if (session()->has('id_aluno_pdf')) {
			$id_aluno_pdf = session()->get('id_aluno_pdf');
		}else{
			$id_aluno_pdf = null;
		}
		

		$inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->paginate(10);


		foreach ($inscricoes_finalizadas as $candidato ) {

			$cartas = new CartaRecomendacao();

			$total_cartas[$candidato->id_candidato]=  $cartas->conta_cartas_enviadas_por_candidato($candidato->id_inscricao_pos, $candidato->id_candidato);
		}

		$classes_linhas[0] = 'danger';
		$classes_linhas[1] = 'warning';
		$classes_linhas[2] = 'info';
		$classes_linhas[3] = 'success';



		return view('templates.partials.coordenador.ficha_individual', compact('inscricoes_finalizadas', 'total_cartas', 'classes_linhas', 'nome_pdf', 'id_aluno_pdf'));
		
	}

	public function GeraPdfFichaIndividual()
	{

		$user = Auth::user();
		

		$id_inscricao_pos = (int) $_GET['id_inscricao_pos'];
		
		$id_aluno_pdf = (int) $_GET['id_aluno'];

		$ficha = new RelatorioController;
	
		$nome_pdf = $ficha->geraFichaIndividual($id_aluno_pdf, $this->locale_default);
      	
      	
      	return redirect()->back()->with(compact('nome_pdf','id_aluno_pdf'));
	}
}