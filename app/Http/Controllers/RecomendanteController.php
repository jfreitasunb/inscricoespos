<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\CartaMotivacao;
use Posmat\Models\ProgramaPos;
use Posmat\Models\DadoPessoal;
use Posmat\Models\Formacao;
use Posmat\Models\Estado;
use Posmat\Models\DadoAcademico;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\DadoRecomendante;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\FinalizaInscricao;
use Posmat\Models\Documento;
use Posmat\Notifications\NotificaRecomendante;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Posmat\Http\Requests;
use Illuminate\Support\Facades\Response;

/**
* Classe para manipulação do recomendante.
*/
class RecomendanteController extends BaseController
{

	public function getMenu()
	{	
		return view('home');
	}
/*
/Gravação dos dados Pessoais
 */

	public function getDadosPessoaisRecomendante()
	{

		$user = Auth::user();
		$id_user = $user->id_user;
		
		$recomendante = new DadoRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$dados = $recomendante->retorna_dados_pessoais_recomendante($id_user);

		return view('templates.partials.recomendante.dados_pessoais')->with(compact('countries','dados'));
		
	}

	public function postDadosPessoaisRecomendante(Request $request)
	{
		$this->validate($request, [
			'nome_recomendante' => 'required',
			'instituicao_recomendante' => 'required',
			'titulacao_recomendante' => 'required',
			'area_recomendante' => 'required',
			'ano_titulacao' => 'required',
			'inst_obtencao_titulo' => 'required',
			'endereco_recomendante' => 'required',
		]);

		$user = Auth::user();
		$id_user = $user->id_user;
		
		$recomendante = new DadoRecomendante();

		$id_recomendante = $recomendante->select('id')->where('id_prof', $id_user)->pluck('id');

		

		$atualiza_dados_recomendantes['nome_recomendante'] = Purifier::clean(trim($request->input('nome_recomendante')));
		$atualiza_dados_recomendantes['instituicao_recomendante'] = Purifier::clean(trim($request->input('instituicao_recomendante')));
		$atualiza_dados_recomendantes['titulacao_recomendante'] = Purifier::clean(trim($request->input('titulacao_recomendante')));
		$atualiza_dados_recomendantes['area_recomendante'] = Purifier::clean(trim($request->input('area_recomendante')));
		$atualiza_dados_recomendantes['ano_titulacao'] = Purifier::clean(trim($request->input('ano_titulacao')));
		$atualiza_dados_recomendantes['endereco_recomendante'] = Purifier::clean(trim($request->input('endereco_recomendante')));
		$atualiza_dados_recomendantes['atualizado'] = true;

		DB::table('dados_recomendantes')->where('id', $id_recomendante[0])->where('id_prof', $id_user)->update($atualiza_dados_recomendantes);
	}

	public function getCartasPendentes()
	{

		$user = Auth::user();
		$id_user = $user->id_user;
		
		$recomendante = new DadoRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($autoriza_carta) {
			
			$recomendante_indicado = new ContatoRecomendante();

			$indicacoes = $recomendante_indicado->retorna_indicacoes($id_user,$id_inscricao_pos);

			foreach ($indicacoes as $indicado) {
				
				$indicador = new DadoPessoal();

				$dados_indicador = $indicador->retorna_dados_pessoais($indicado->id_user);

				$dados_para_template[$indicado->id_user]['id_candidato'] = $indicado->id_user;

				$dados_para_template[$indicado->id_user]['nome_candidato'] = $dados_indicador->nome;

				$dados_cartas = new CartaRecomendacao();

				$carta_aluno = $dados_cartas->retorna_carta_recomendacao($id_user,$indicado->id_user,$id_inscricao_pos);

				$dados_para_template[$indicado->id_user]['status_carta'] = $carta_aluno->completada;

			}

			return view('templates.partials.recomendante.cartas_pendentes',compact('dados_para_template'));

		}else{

			notify()->flash(trans('tela_cartas_pendentes.prazo_carta'), 'info');

			return redirect()->back();
		}
	}

	public function getPreencherCarta()
	{
		$id_candidato= (int)$_GET['id_candidato'];

		$user = Auth::user();
		$id_user = $user->id_user;
		
		$recomendante = new DadoRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($autoriza_carta) {

			$carta_recomendacao = new CartaRecomendacao();

			$dados = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);
			
			return view('templates.partials.recomendante.carta_parte_inicial', compact('dados','id_candidato'));
		}else{

			notify()->flash(trans('tela_cartas_pendentes.prazo_carta'),'info');
			return redirect()->back();
		}
	}

	public function postPreencherCarta(Request $request)
	{
		$this->validate($request, [
			'tempo_conhece_candidato' => 'required',
			'desempenho_academico' => 'required',
			'capacidade_aprender' => 'required',
			'capacidade_trabalhar' => 'required',
			'criatividade' => 'required',
			'curiosidade' => 'required',
			'esforco' => 'required',
			'expressao_escrita' => 'required',
			'expressao_oral' => 'required',
			'relacionamento' => 'required',
			'circunstancia_outra' => 'required_without_all:circunstancia_1,circunstancia_2,circunstancia_3,circunstancia_4',
		]);

		$id_candidato = (int)$request->input('id_candidato');

		$user = Auth::user();
		$id_user = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($autoriza_carta) {

			$carta_recomendacao = new CartaRecomendacao();

			$carta_atual = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);

			if ($carta_atual->completada) {
				
				notify()->flash(trans('tela_cartas_parte_inicial.carta_enviada'),'info');
				return redirect()->back();
			}else{

				$atualiza_carta['tempo_conhece_candidato'] = Purifier::clean(trim($request->input('tempo_conhece_candidato')));
				$atualiza_carta['circunstancia_1'] = Purifier::clean(trim($request->input('circunstancia_1')));
				$atualiza_carta['circunstancia_2'] = Purifier::clean(trim($request->input('circunstancia_2')));
				$atualiza_carta['circunstancia_3'] = Purifier::clean(trim($request->input('circunstancia_3')));
				$atualiza_carta['circunstancia_4'] = Purifier::clean(trim($request->input('circunstancia_4')));
				$atualiza_carta['circunstancia_outra'] = Purifier::clean(trim($request->input('circunstancia_outra')));
				$atualiza_carta['desempenho_academico'] = Purifier::clean(trim($request->input('desempenho_academico')));
				$atualiza_carta['capacidade_aprender'] = Purifier::clean(trim($request->input('capacidade_aprender')));
				$atualiza_carta['capacidade_trabalhar'] = Purifier::clean(trim($request->input('capacidade_trabalhar')));
				$atualiza_carta['criatividade'] = Purifier::clean(trim($request->input('criatividade')));
				$atualiza_carta['curiosidade'] = Purifier::clean(trim($request->input('curiosidade')));
				$atualiza_carta['esforco'] = Purifier::clean(trim($request->input('esforco')));
				$atualiza_carta['expressao_escrita'] = Purifier::clean(trim($request->input('expressao_escrita')));
				$atualiza_carta['expressao_oral'] = Purifier::clean(trim($request->input('expressao_oral')));
				$atualiza_carta['relacionamento'] = Purifier::clean(trim($request->input('relacionamento')));

				DB::table('cartas_recomendacoes')->where('id_prof', $carta_atual->id_prof)->where('id_aluno', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update($atualiza_carta);

				return redirect()->route('finalizar.carta', ['id_candidato' => $id_candidato]);
			}
		}else{

			notify()->flash(trans('tela_cartas_pendentes.prazo_carta'),'info');
			return redirect()->back();
		}
	}

	public function getFinalizarCarta()
	{
		$id_candidato = (int)$_GET['id_candidato'];

		$user = Auth::user();
		$id_user = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($autoriza_carta) {

			$carta_recomendacao = new CartaRecomendacao();

			$dados = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);

			if ($dados->completada) {
				notify()->flash(trans('tela_cartas_parte_inicial.carta_enviada'),'info');
				return redirect()->back();
			}else{
				return view('templates.partials.recomendante.carta_parte_final', compact('dados','id_candidato'));
			}
		}else{

			notify()->flash(trans('tela_cartas_pendentes.prazo_carta'),'info');
			return redirect()->back();
		}
	}

	public function postFinalizarCarta(Request $request)
	{

		$this->validate($request, [
			'antecedentes_academicos' => 'required',
			'possivel_aproveitamento' => 'required',
			'informacoes_relevantes' => 'required',
			'como_aluno' => 'required',
			'como_orientando' => 'required',
		]);

	}

}