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
use InscricoesPos\Models\AreaInscricoesPos;
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
use InscricoesPos\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use InscricoesPos\Http\Requests;
use Illuminate\Support\Facades\Response;

/**
* Classe para manipulação do recomendante.
*/
class PreencherCartaController extends RecomendanteController
{

	public function postCartaInicial()
	{	
		$locale_recomendante = Session::get('locale');

		if (!isset($_POST['id_candidato'])) {
			
			notify()->flash(trans('tela_carta_parte_inicial.sem_carta_seleciona'), 'error');

			return redirect()->back();

		}
		
		$id_candidato= (int)$_POST['id_candidato'];

		$user = $this->SetUser();

		$id_user = $user->id_user;
		
		$recomendante = new DadoPessoalRecomendante();
		$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($autoriza_carta) {

			$carta_recomendacao = new CartaRecomendacao();

			$candidato = new DadoPessoalCandidato();

			$programa = new EscolhaCandidato();

			$programa_pretendido_candidato = $programa->retorna_escolha_candidato($id_candidato,$id_inscricao_pos);

			$nome_programa_pos = new ProgramaPos();

			$dados_pessoais_candidato = $candidato->retorna_dados_pessoais($id_candidato);

			$dados_candidato['nome_candidato'] = $dados_pessoais_candidato->nome;

			$dados_candidato['programa_pretendido'] = $nome_programa_pos->pega_programa_pos_mat($programa_pretendido_candidato->programa_pretendido, $locale_recomendante);


			$dados_antigos = $carta_recomendacao->retorna_carta_recomendacao_antiga($id_user,$id_candidato,$id_inscricao_pos);

			$dados_atuais = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);

			if (is_null($dados_antigos)) {
				$dados = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);
			}else{
				$dados = $dados_antigos;
			}

			if (!is_null($dados_atuais->tempo_conhece_candidato)) {
				
				$dados = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);
			}

			if (!is_null($dados_antigos) && is_null($dados_atuais->tempo_conhece_candidato)) {
				
				notify()->flash(trans('tela_cartas_pendentes.mensagem_carta_antiga'),'info');
			}

			return view('templates.partials.recomendante.carta_parte_inicial', compact('dados_candidato','dados','id_candidato'));
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

		$user = $this->SetUser();

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
				$atualiza_carta['desempenho_academico'] = (int) Purifier::clean(trim($request->input('desempenho_academico')));
				$atualiza_carta['capacidade_aprender'] = (int) Purifier::clean(trim($request->input('capacidade_aprender')));
				$atualiza_carta['capacidade_trabalhar'] = (int) Purifier::clean(trim($request->input('capacidade_trabalhar')));
				$atualiza_carta['criatividade'] = (int) Purifier::clean(trim($request->input('criatividade')));
				$atualiza_carta['curiosidade'] = (int) Purifier::clean(trim($request->input('curiosidade')));
				$atualiza_carta['esforco'] = (int) Purifier::clean(trim($request->input('esforco')));
				$atualiza_carta['expressao_escrita'] = (int) Purifier::clean(trim($request->input('expressao_escrita')));
				$atualiza_carta['expressao_oral'] = (int) Purifier::clean(trim($request->input('expressao_oral')));
				$atualiza_carta['relacionamento'] = (int) Purifier::clean(trim($request->input('relacionamento')));
				$atualiza_carta['updated_at'] = date('Y-m-d H:i:s');

				DB::table('cartas_recomendacoes')->where('id_recomendante', $carta_atual->id_recomendante)->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update($atualiza_carta);

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

		$user = $this->SetUser();

		$id_user = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($autoriza_carta) {

			$carta_recomendacao = new CartaRecomendacao();

			$dados_antigos = $carta_recomendacao->retorna_carta_recomendacao_antiga($id_user,$id_candidato,$id_inscricao_pos);

			$dados_atuais = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);

			if ($dados_atuais->completada) {
				notify()->flash(trans('tela_cartas_parte_inicial.carta_enviada'),'info');
				return redirect()->back();
			}

			if (is_null($dados_antigos)) {
				$dados = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);
			}

			if (!is_null($dados_atuais->antecedentes_academicos)) {
				
				$dados = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);
			}else{
				
				$dados = $carta_recomendacao->retorna_carta_recomendacao_antiga($id_user,$id_candidato,$id_inscricao_pos);
			}

			if (!is_null($dados_antigos) && is_null($dados_atuais->tempo_conhece_candidato)) {
				
				notify()->flash(trans('tela_cartas_pendentes.mensagem_carta_antiga'),'info');

			}

			return view('templates.partials.recomendante.carta_parte_final', compact('dados','id_candidato'));

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

		$id_candidato = (int)$request->input('id_candidato');

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_carta = $edital_ativo->autoriza_carta();

		if ($autoriza_carta) {

			$carta_recomendacao = new CartaRecomendacao();

			$carta_atual = $carta_recomendacao->retorna_carta_recomendacao($id_user,$id_candidato,$id_inscricao_pos);

			if ($carta_atual->completada) {
				
				notify()->flash(trans('tela_carta_parte_inicial.carta_enviada'),'info');
				return redirect()->back();
			}else{

				$atualiza_carta['antecedentes_academicos'] = Purifier::clean(trim($request->input('antecedentes_academicos')));
				$atualiza_carta['possivel_aproveitamento'] = Purifier::clean(trim($request->input('possivel_aproveitamento')));
				$atualiza_carta['informacoes_relevantes'] = Purifier::clean(trim($request->input('informacoes_relevantes')));
				$atualiza_carta['como_aluno'] = (int) Purifier::clean(trim($request->input('como_aluno')));
				$atualiza_carta['como_orientando'] = (int) Purifier::clean(trim($request->input('como_orientando')));
				$atualiza_carta['completada'] = true;
				$atualiza_carta['updated_at'] = date('Y-m-d H:i:s');

				DB::table('cartas_recomendacoes')->where('id_recomendante', $carta_atual->id_recomendante)->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update($atualiza_carta);

				$recomendante = new DadoPessoalRecomendante();
				$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

				if ($status_dados_pessoais->atualizado) {

					notify()->flash(trans('mensagens_gerais.mensagem_sucesso'),'success');

					return redirect()->route('cartas.pendentes');
				}else{

					$recomendante = new DadoPessoalRecomendante();
					$status_dados_pessoais = $recomendante->dados_atualizados_recomendante($id_user);

					if (!$status_dados_pessoais->atualizado) {
						
						notify()->flash(trans('tela_recomendante_dados_pessoais.atualizar_dados'));

						return redirect()->route('dados.recomendante');
					}
				}
			}
		}else{

			notify()->flash(trans('tela_cartas_pendentes.prazo_carta'),'info');
			return redirect()->route('/');
		}
	}
}