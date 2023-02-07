<?php

namespace InscricoesPos\Http\Controllers\Candidato;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\AssociaEmailsRecomendante;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaMotivacao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DadoPessoalCandidato;
use InscricoesPos\Models\DisciplinaDestaque;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\DadoAcademicoCandidato;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\DadoRecomendante;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\Documento;
use InscricoesPos\Models\Paises;
use InscricoesPos\Models\Cidade;
use InscricoesPos\Notifications\NotificaRecomendante;
use InscricoesPos\Notifications\NotificaCandidato;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use InscricoesPos\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
* Classe para manipulação do candidato.
*/
class DadosAcademicosController extends BaseController
{

/*
/Gravação dos dados Acadêmicos
 */
	public function getDadosAcademicos()
	{
		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;
		
		$locale_candidato = Session::get('locale');

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;

		switch ($locale_candidato) {
		 	case 'en':
		 		$nome_coluna = 'tipo_en';
		 		break;

		 	case 'es':
		 		$nome_coluna = 'tipo_es';
		 		break;
		 	
		 	default:
		 		$nome_coluna = 'tipo_ptbr';
		 		break;
		 }

		$dados_academicos = new DadoAcademicoCandidato();

		$tipo_formacao = new Formacao();

		$graduacao = $tipo_formacao->where('nivel','Graduação')->whereNotNull($nome_coluna)->pluck($nome_coluna,'id')->prepend(trans('mensagens_gerais.selecionar'),'');

		$pos = $tipo_formacao->where('nivel','Pós-Graduação')->whereNotNull($nome_coluna)->pluck($nome_coluna,'id')->prepend(trans('mensagens_gerais.selecionar'),'');;

		$dados_academicos_candidato = $dados_academicos->retorna_dados_academicos($id_candidato);

		$nivel_candidato[0] = 'Especialista';
		
		$nivel_candidato[1] = 'Mestrado';
		
		$nivel_candidato[2] = 'Doutorado';

		$destaque = new DisciplinaDestaque();

		$disciplinas_destaque = $destaque->retorna_disciplinas_destaque($id_candidato, $id_inscricao_pos);

		if (is_null($dados_academicos_candidato)) {

			$dados = [];

			$dados['curso_graduacao'] = '';

			$dados['tipo_curso_graduacao'] = '';

			$dados['instituicao_graduacao'] = '';

			$dados['ano_conclusao_graduacao'] = '';

			$dados['curso_pos'] = '';

			$dados['tipo_curso_pos'] = '';
			// $dados['nivel_pos'] = '';
			$dados['instituicao_pos'] = '';

			$dados['ano_conclusao_pos'] = '';

			return view('templates.partials.candidato.dados_academicos')->with(compact('dados', 'graduacao', 'nivel_candidato','pos', 'disciplinas_destaque'));
		}else{

			$dados['curso_graduacao'] = $dados_academicos_candidato->curso_graduacao;

			$dados['tipo_curso_graduacao'] = $dados_academicos_candidato->tipo_curso_graduacao;

			$dados['instituicao_graduacao'] = $dados_academicos_candidato->instituicao_graduacao;

			$dados['ano_conclusao_graduacao'] = $dados_academicos_candidato->ano_conclusao_graduacao;

			$dados['curso_pos'] = $dados_academicos_candidato->curso_pos;
			// $dados['nivel_pos'] = $dados_academicos_candidato->nivel_pos;

			$dados['tipo_curso_pos'] = $dados_academicos_candidato->tipo_curso_pos;

			$dados['instituicao_pos'] = $dados_academicos_candidato->instituicao_pos;

			$dados['ano_conclusao_pos'] = $dados_academicos_candidato->ano_conclusao_pos;

			return view('templates.partials.candidato.dados_academicos')->with(compact('dados', 'graduacao', 'nivel_candidato', 'pos', 'disciplinas_destaque'));
		}
	}

	public function postDadosAcademicos(Request $request)
	{
		$this->validate($request, [
			'curso_pos' => 'required_without_all:curso_graduacao',
			'tipo_curso_pos' => 'required_without_all:tipo_curso_graduacao',
			'instituicao_pos' => 'required_without_all:instituicao_graduacao',
			'ano_conclusao_pos' => 'required_without_all:ano_conclusao_graduacao',
		]);

		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;
		
		$formacao = new Formacao;

		$nivel_candidato[0] = 'Especialista';

		$nivel_candidato[1] = 'Mestrado';

		$nivel_candidato[2] = 'Doutorado';

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;

		$destaques = $request->discplinas_destaque;

		$remover = $request->remover_destaque;

		if (isset($remover)) {
			foreach ($remover as $key => $value) {
				if ($value[0]) {
					$deleted = DB::table('disciplinas_destaque')->where('id_candidato', '=', $id_candidato)->where('id_inscricao_pos', '=', $id_inscricao_pos)->where('id', '=', $key)->delete();
				}
			}
		}

		$dados_academicos = DadoAcademicoCandidato::find($id_candidato);

		$cria_dados_academicos['curso_graduacao'] = $this->titleCase(Purifier::clean(trim($request->input('curso_graduacao'))));

		$cria_dados_academicos['tipo_curso_graduacao'] = (int)Purifier::clean(trim($request->input('tipo_curso_graduacao')));

		$cria_dados_academicos['instituicao_graduacao'] = $this->titleCase(Purifier::clean(trim($request->input('instituicao_graduacao'))));

		$cria_dados_academicos['ano_conclusao_graduacao'] = (int)Purifier::clean(trim($request->input('ano_conclusao_graduacao')));

		$cria_dados_academicos['curso_pos'] = $this->titleCase(Purifier::clean(trim($request->input('curso_pos'))));
		
		if (is_null(($request->input('tipo_curso_pos')))) {

			$cria_dados_academicos['tipo_curso_pos'] = 9;
		}else{

			$cria_dados_academicos['tipo_curso_pos'] = (int)Purifier::clean(trim($request->input('tipo_curso_pos')));
		}
		
		$cria_dados_academicos['instituicao_pos'] = $this->titleCase(Purifier::clean(trim($request->input('instituicao_pos'))));

		$cria_dados_academicos['ano_conclusao_pos'] = (int)Purifier::clean(trim($request->input('ano_conclusao_pos')));

		if (is_null($dados_academicos)) {

			$cria_dados_academicos = new DadoAcademicoCandidato();

			$cria_dados_academicos->id_candidato = $id_candidato;

			$cria_dados_academicos->curso_graduacao = Purifier::clean(trim($request->input('curso_graduacao')));

			$cria_dados_academicos->tipo_curso_graduacao = (int)Purifier::clean(trim($request->input('tipo_curso_graduacao')));

			$cria_dados_academicos->instituicao_graduacao = Purifier::clean(trim($request->input('instituicao_graduacao')));

			$cria_dados_academicos->ano_conclusao_graduacao = (int)Purifier::clean(trim($request->input('ano_conclusao_graduacao')));

			$cria_dados_academicos->curso_pos = Purifier::clean(trim($request->input('curso_pos')));

			if (is_null(($request->input('tipo_curso_pos')))) {

				$cria_dados_academicos->tipo_curso_pos = 9;	
			}else{

				$cria_dados_academicos->tipo_curso_pos = (int)Purifier::clean(trim($request->input('tipo_curso_pos')));
			}
			
			$cria_dados_academicos->instituicao_pos = Purifier::clean(trim($request->input('instituicao_pos')));
			$cria_dados_academicos->ano_conclusao_pos = (int)Purifier::clean(trim($request->input('ano_conclusao_pos')));

			$cria_dados_academicos->save();

			foreach ($destaques as $destaque) {

				
				if (!is_null($destaque['nome_disciplina'])) {
					
					$discplina_destaque = new DisciplinaDestaque();

					$discplina_destaque->id_candidato = $id_candidato;

					$discplina_destaque->id_inscricao_pos = $id_inscricao_pos;

					$discplina_destaque->nome_disciplina = Purifier::clean(trim($destaque['nome_disciplina']));

					$discplina_destaque->mencao = $destaque['mencao'];

					$discplina_destaque->save();
				}
			}


		}else{
			
			foreach ($destaques as $destaque) {

				if (!is_null($destaque['nome_disciplina'])) {
					$discplina_destaque = new DisciplinaDestaque();

					$discplina_destaque->id_candidato = $id_candidato;

					$discplina_destaque->id_inscricao_pos = $id_inscricao_pos;

					$discplina_destaque->nome_disciplina = $destaque['nome_disciplina'];

					$discplina_destaque->mencao = $destaque['mencao'];

					$discplina_destaque->save();
				}
			}

			$dados_academicos->update($cria_dados_academicos);
		}

		return redirect()->route('dados.escolhas');
	}
}