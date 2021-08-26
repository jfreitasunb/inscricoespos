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
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\DadoAcademico;
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
class DadosPessoaisController extends BaseController
{

	/*
/Gravação dos dados Pessoais
 */

	public function getDadosPessoais()
	{

		$getcountries = new APIController();

		$countries = $getcountries->index();

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$editar_dados = false;
		
		$candidato = new DadoPessoalCandidato();
		
		$dados_pessoais = $candidato->retorna_dados_pessoais($id_user);

		if (is_null($dados_pessoais)) {
			
			$dados = [
				'nome' => $this->titleCase($user->nome),
				'data_nascimento' => '',
				'numerorg' => '',
				'emissorrg' => '',
				'cpf' => '',
				'data_nascimento' => '',
				'endereco' => '',
				'pais' => '',
				'estado' => '',
				'cidade' => '',
				'cep' => '',
				'celular' => '',
			];
		}else{
			
			if (!is_null($dados_pessoais->data_nascimento)) {
			
				$nascimento = Carbon::createFromFormat('Y-m-d',$dados_pessoais->data_nascimento);

				$data_nascimento = $nascimento->format('d/m/Y');
			}else{
			
				$data_nascimento = '';
			}
			

			$nome_pais = new Paises;

			$nome_estado = new Estado;

			$nome_cidade = new Cidade;

			if (!is_null($dados_pessoais->pais)) {
			
				$pais = $nome_pais->retorna_nome_pais_por_id($dados_pessoais->pais);
			}else{

				$pais = '';
			}

			if (!is_null($dados_pessoais->estado)) {
			
				$estado = $nome_estado->retorna_nome_estados_por_id($dados_pessoais->pais, $dados_pessoais->estado);
			}else{

				$estado = '';
			}

			if (!is_null($dados_pessoais->cidade)) {
				
				$cidade = $nome_cidade->retorna_nome_cidade_por_id($dados_pessoais->cidade, $dados_pessoais->estado);
			}else{

				$cidade = '';
			}

			$dados = [
				'nome' => $this->titleCase($dados_pessoais->nome),
				'data_nascimento' => $dados_pessoais->data_nascimento,
				'numerorg' => $dados_pessoais->numerorg,
				'emissorrg' => $dados_pessoais->emissorrg,
				'cpf' => $dados_pessoais->cpf,
				'data_nascimento' => $data_nascimento,
				'endereco' => $dados_pessoais->endereco,
				'pais' => $pais,
				'estado' => $estado,
				'cidade' => $cidade,
				'cep' => $dados_pessoais->cep,
				'celular' => $dados_pessoais->celular,
			];
		}

		return view('templates.partials.candidato.dados_pessoais')->with(compact('countries','dados','editar_dados'));
	}

	public function getDadosPessoaisEditar()
	{

		$getcountries = new APIController();

		$countries = $getcountries->index();

		$user = $this->SetUser();
		
		$nome = $user->nome;
		
		$id_user = $user->id_user;

		$editar_dados = true;
		
		$candidato = new DadoPessoalCandidato();
		
		$dados_pessoais = $candidato->retorna_dados_pessoais($id_user);

		if (is_null($dados_pessoais)) {
			
			$dados = [
					'nome' => $this->titleCase($user->nome),
					'data_nascimento' => '',
					'numerorg' => '',
					'emissorrg' => '',
					'cpf' => '',
					'data_nascimento' => '',
					'endereco' => '',
					'pais' => '',
					'estado' => '',
					'cidade' => '',
					'cep' => '',
					'celular' => '',
			];
		}else{
			
			$dados = [
				'nome' => $this->titleCase($dados_pessoais->nome),
				'data_nascimento' => $dados_pessoais->data_nascimento,
				'numerorg' => $dados_pessoais->numerorg,
				'emissorrg' => $dados_pessoais->emissorrg,
				'cpf' => $dados_pessoais->cpf,
				'data_nascimento' => $dados_pessoais->data_nascimento,
				'endereco' => $dados_pessoais->endereco,
				'pais' => $dados_pessoais->pais,
				'estado' => $dados_pessoais->estado,
				'cidade' => $dados_pessoais->cidade,
				'cep' => $dados_pessoais->cep,
				'celular' => $dados_pessoais->celular,
			];
		}

		return view('templates.partials.candidato.dados_pessoais')->with(compact('countries','dados','editar_dados'));
	}

	public function postDadosPessoais(Request $request)
	{
		$this->validate($request, [
			'nome' => 'max:256',
			'data_nascimento' => 'required',
			'numerorg' => 'required|max:21',
			'endereco' => 'required|max:256',
			'cep' => 'required|max:20',
			'pais' => 'required',
			'celular' => 'max:21',
		]);

		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;

		$nascimento = Carbon::createFromFormat('d/m/Y', Purifier::clean(trim($request->data_nascimento)));

		$data_nascimento = $nascimento->format('Y-m-d');
	
		$dados_pessoais = [
			'id_candidato' => $id_candidato,
			'data_nascimento' => $data_nascimento,
			'numerorg' => Purifier::clean(trim($request->input('numerorg'))),
			'endereco' => Purifier::clean(trim($request->input('endereco'))),
			'cep' => Purifier::clean(trim($request->input('cep'))),
			'estado' => $request->input('estado'),
			'cidade' => $request->input('cidade'),
			'pais' => $request->input('pais'),
			'celular' => Purifier::clean(trim($request->input('celular'))),
		];

		$candidato =  DadoPessoalCandidato::find($id_candidato);
		
		$usuario = User::find($id_candidato);

		$update_nome['nome'] = $this->titleCase(Purifier::clean(trim($request->input('nome'))));

		if (is_null($candidato)) {

			$cria_candidato = new DadoPessoalCandidato();

			$cria_candidato->id_candidato = $id_candidato;

			$cria_candidato->data_nascimento = $data_nascimento;

			$cria_candidato->numerorg = Purifier::clean(trim($request->input('numerorg')));

			$cria_candidato->endereco = Purifier::clean(trim($request->input('endereco')));

			$cria_candidato->cep = Purifier::clean(trim($request->input('cep')));

			$cria_candidato->estado = $request->input('estado');

			$cria_candidato->cidade = $request->input('cidade');

			$cria_candidato->pais = $request->input('pais');

			$cria_candidato->celular = Purifier::clean(trim($request->input('celular')));

			$cria_candidato->save($dados_pessoais);

			$usuario->update($update_nome);

		}else{
			
			$candidato->update($dados_pessoais);

			$usuario->update($update_nome);
		}


		notify()->flash('Seus dados pessoais foram atualizados.','success');

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;

		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;

		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		$finaliza_inscricao = new FinalizaInscricao();

		$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_candidato,$id_inscricao_pos);

		if ($autoriza_inscricao and !$status_inscricao) {

			return redirect()->route('dados.academicos');
		}else{

			return redirect()->back();
		}
	}
}