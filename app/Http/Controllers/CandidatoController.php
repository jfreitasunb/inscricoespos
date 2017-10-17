<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\ProgramaPos;
use Posmat\Models\DadoPessoal;
use Posmat\Models\Formacao;
use Posmat\Models\Estado;
use Posmat\Models\DadoAcademico;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\DadoRecomendante;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\FinalizaEscolha;
use Posmat\Models\Documento;
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
* Classe para manipulação do candidato.
*/
class CandidatoController extends BaseController
{

	private $estadoModel;

    public function __construct(Estado $estado)
    {
        $this->estadoModel = $estado;
    }

    public function getCidades($idEstado)
    {
        $estado = $this->estadoModel->find($idEstado);
        $cidades = $estado->cidades()->getQuery()->get(['id', 'cidade']);
        return Response::json($cidades);
    }
	public function getMenu()
	{	
		return view('home');
	}

/*
/Gravação dos dados Pessoais
 */

	public function getDadosPessoais()
	{

		$getcountries = new APIController();

		$countries = $getcountries->index();

		$user = Auth::user();
		$nome = $user->nome;
		$id_user = $user->id_user;
		
		$candidato = new DadoPessoal();
		$dados_pessoais = $candidato->retorna_dados_pessoais($id_user);

		$dados = [
			'nome' => $dados_pessoais->nome,
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

		return view('templates.partials.candidato.dados_pessoais')->with(compact('countries','dados'));
		
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
				'estado' => 'required|max:3',
				'cidade' => 'required',
				'celular' => 'required|max:21',
			]);

			$user = Auth::user();
			$id_user = $user->id_user;

    		$nascimento = Carbon::createFromFormat('d/m/Y', Purifier::clean(trim($request->data_nascimento)));

    		$data_nascimento = $nascimento->format('Y-m-d');
    	
			$dados_pessoais = [
				'id_user' => $id_user,
				'data_nascimento' => $data_nascimento,
				'numerorg' => Purifier::clean(trim($request->input('numerorg'))),
				'endereco' => Purifier::clean(trim($request->input('endereco'))),
				'cep' => Purifier::clean(trim($request->input('cep'))),
				'estado' => $request->input('estado'),
				'cidade' => $request->input('cidade'),
				'pais' => $request->input('pais'),
				'celular' => Purifier::clean(trim($request->input('celular'))),
			];

			$candidato =  DadoPessoal::find($id_user);

			if (is_null($candidato)) {
				$cria_candidato = new DadoPessoal();
				$cria_candidato->id_user = $id_user;
				$cria_candidato->nome = Purifier::clean(trim($request->input('nome')));
				$cria_candidato->data_nascimento = $data_nascimento;
				$cria_candidato->numerorg = Purifier::clean(trim($request->input('numerorg')));
				$cria_candidato->endereco = Purifier::clean(trim($request->input('endereco')));
				$cria_candidato->cep = Purifier::clean(trim($request->input('cep')));
				$cria_candidato->estado = $request->input('estado');
				$cria_candidato->cidade = $request->input('cidade');
				$cria_candidato->pais = $request->input('pais');
				$cria_candidato->celular = Purifier::clean(trim($request->input('celular')));
				$cria_candidato->save($dados_pessoais);
			}else{
				
				$candidato->update($dados_pessoais);
			}


			notify()->flash('Seus dados pessoais foram atualizados.','success',[
				'showCancelButton' => false,
				'confirmButtonColor' => '#3085d6',
				'confirmButtonText' => 'OK',
				'notifica' => true,
				'notifica_mensagem' =>'Caso você esteja se candidantando à monitoria voluntária não é necessário informar os dados bancários.',
				'notifica_tipo' => 'info'
			]);

			return redirect()->route('dados.bancarios');
	}

/*
/Gravação dos dados Bancários
 */

	public function getDadosBancarios()
	{
		$user = Auth::user();
		$id_user = $user->id_user;
		
		$candidato = new DadoBancario();
		$dados_bancarios = $candidato->retorna_dados_bancarios($id_user);

		if (!is_null($dados_bancarios)) {
			$dados = [
				'nome_banco' => $dados_bancarios->nome_banco,
				'numero_banco' => $dados_bancarios->numero_banco,
				'agencia_bancaria' => $dados_bancarios->agencia_bancaria,
				'numero_conta_corrente' => $dados_bancarios->numero_conta_corrente,
			];

			return view('templates.partials.candidato.dados_bancarios')->with('dados', $dados);	
		}else{
			
			return view('templates.partials.candidato.dados_bancarios');
		}
		
	}

	public function postDadosBancarios(Request $request)
	{
		$this->validate($request, [
			'nome_banco' => 'required|max:21',
			'numero_banco' => 'required|max:201',
			'agencia_bancaria' => 'required',
			'numero_conta_corrente' => 'required|max:256',
		]);

			$user = Auth::user();
			$id_user = $user->id_user;
			
			$dados_bancarios = [
				'id_user' => $id_user,
				'nome_banco' => $request->input('nome_banco'),
				'numero_banco' => $request->input('numero_banco'),
				'agencia_bancaria' => $request->input('agencia_bancaria'),
				'numero_conta_corrente' => $request->input('numero_conta_corrente'),
			];

			$banco =  DadoBancario::find($id_user);

			if (is_null($banco)) {
				$cria_banco = new DadoBancario();
				$cria_banco->id_user = $id_user;
				$cria_banco->nome_banco = $request->input('nome_banco');
				$cria_banco->numero_banco = $request->input('numero_banco');
				$cria_banco->agencia_bancaria = $request->input('agencia_bancaria');
				$cria_banco->numero_conta_corrente = $request->input('numero_conta_corrente');
				$cria_banco->save();
			}else{
				
				$banco->update($dados_bancarios);
			}

			notify()->flash('Seus dados bancários foram atualizados.','success',[
				'showCancelButton' => false,
				'confirmButtonColor' => '#3085d6',
				'confirmButtonText' => 'OK',
				'notifica' => true,
				'notifica_mensagem' =>'Agora você deve informar seus dados acadêmicos.',
				'notifica_tipo' => 'info'
			]);

			return redirect()->route('dados.academicos');
	}

/*
/Gravação dos dados Acadêmicos
 */
	public function getDadosAcademicos()
	{
		$user = Auth::user();
		$id_user = $user->id_user;
		
		$dados_academicos = new DadoAcademico();

		$tipo_formacao = new Formacao();

		$graduacao = $tipo_formacao->where('nivel','Graduação')->pluck('tipo','id')->prepend(trans('mensagens_gerais.selecionar'),'');

		$pos = $tipo_formacao->where('nivel','Pós-Graduação')->pluck('tipo','id')->prepend(trans('mensagens_gerais.selecionar'),'');;

		$dados_academicos_candidato = $dados_academicos->retorna_dados_academicos($id_user);

		if (is_null($dados_academicos_candidato)) {
			$dados = [];
			return view('templates.partials.candidato.dados_academicos')->with(compact('dados', 'graduacao','pos'));
		}else{
			
			return view('templates.partials.candidato.dados_academicos')->with(compact('dados', 'graduacao','pos'));
		}

		
		
	}

	public function postDadosAcademicos(Request $request)
	{
		// $this->validate($request, [
		// 	'curso_graduacao' => 'required|max:201',
		// 	'checkbox_foi_monitor' => 'required',
		// 	'arquivo' => 'required|max:20000'
		// ]);

			$user = Auth::user();
			$id_user = $user->id_user;
			
			$dados_academicos = DadoAcademico::find($id_user);

			$cria_dados_academicos['curso_graduacao'] = Purifier::clean(trim($request->input('curso_graduacao')));
			$cria_dados_academicos['tipo_curso_graduacao'] = (int)Purifier::clean(trim($request->input('tipo_curso_graduacao')));
			$cria_dados_academicos['instituicao_graduacao'] = Purifier::clean(trim($request->input('instituicao_graduacao')));
			$cria_dados_academicos['ano_conclusao_graduacao'] = (int)Purifier::clean(trim($request->input('ano_conclusao_graduacao')));
			$cria_dados_academicos['curso_pos'] = Purifier::clean(trim($request->input('curso_pos')));
			$cria_dados_academicos['tipo_curso_pos'] = (int)Purifier::clean(trim($request->input('tipo_curso_pos')));
			$cria_dados_academicos['instituicao_pos'] = Purifier::clean(trim($request->input('instituicao_pos')));
			$cria_dados_academicos['ano_conclusao_pos'] = (int)Purifier::clean(trim($request->input('ano_conclusao_pos')));

			if (is_null($dados_academicos)) {
				$cria_dados_academicos = new DadoAcademico();
				$cria_dados_academicos->id_user = $id_user;
				$cria_dados_academicos->curso_graduacao = Purifier::clean(trim($request->input('curso_graduacao')));
				$cria_dados_academicos->tipo_curso_graduacao = (int)Purifier::clean(trim($request->input('tipo_curso_graduacao')));
				$cria_dados_academicos->instituicao_graduacao = Purifier::clean(trim($request->input('instituicao_graduacao')));
				$cria_dados_academicos->ano_conclusao_graduacao = (int)Purifier::clean(trim($request->input('ano_conclusao_graduacao')));
				$cria_dados_academicos->curso_pos = Purifier::clean(trim($request->input('curso_pos')));
				$cria_dados_academicos->tipo_curso_pos = (int)Purifier::clean(trim($request->input('tipo_curso_pos')));
				$cria_dados_academicos->instituicao_pos = Purifier::clean(trim($request->input('instituicao_pos')));
				$cria_dados_academicos->ano_conclusao_pos = (int)Purifier::clean(trim($request->input('ano_conclusao_pos')));
				$cria_dados_academicos->save();
			}else{
				

				$dados_academicos->update($cria_dados_academicos);
			}

			return redirect()->route('dados.escolhas');
	}


	/*
/Gravação dos escolhas do Candidato
 */
	public function getEscolhaCandidato()
	{
		$user = Auth::user();
		$id_user = $user->id_user;
		
		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			$programas_disponiveis = explode("_", $edital_ativo->retorna_inscricao_ativa()->programa);

			$nome_programa_pos = new ProgramaPos();

			foreach ($programas_disponiveis as $programa) {
				$programa_para_inscricao[$programa] = $nome_programa_pos->pega_programa_pos_mat($programa);
			}

			$finaliza_inscricao = new FinalizaEscolha();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			if (in_array(2, $programas_disponiveis)) {
				
				$areas_pos = AreaPosMat::pluck('nome','id_area_pos')->prepend(trans('mensagens_gerais.selecionar'),'');
			
				return view('templates.partials.candidato.escolha_candidato')->with(compact('disable','programa_para_inscricao','areas_pos'));
			}else{
				return view('templates.partials.candidato.escolha_candidato')->with(compact('disable','programa_para_inscricao'));
			}

			if (in_array(3, $programas_disponiveis)) {
			
				$desativa_recomendante = true;

				return view('templates.partials.candidato.escolha_candidato')->with(compact('disable','programa_para_inscricao','desativa_recomendante'));
			}


		}else{
			
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}
	}

	public function postEscolhaCandidato(Request $request)
	{

		$user = Auth::user();
		$id_user = $user->id_user;
		
		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaEscolha();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			$programas_disponiveis = explode("_", $edital_ativo->retorna_inscricao_ativa()->programa);

			if (!in_array(3, $programas_disponiveis)) {
				
				
				$this->validate($request, [
					'programa_pretendido' => 'required',
					'interesse_bolsa' => 'required',
					'vinculo_empregaticio' => 'required',
					'nome_recomendante' => 'required',
					'email_recomendante' => 'required',
					'confirmar_email_recomendante' => 'required|same:email_recomendante',
				]);

				if ($request->areas_pos === '1' and $request->programa_pretendido === '2') {
					
					notify()->flash(trans('mensagens_gerais.informe_area'),'warning');

					return redirect()->back();
				}


				
				$escolhas_candidato = new EscolhaCandidato();

				$candidato_fez_escolhas = $escolhas_candidato->retorna_escolha_candidato($id_user,$id_inscricao_pos);

				if (count($candidato_fez_escolhas) > 0) {
					
					$atualiza_escolhas = EscolhaCandidato::where('id_user', $id_user)->where('id_inscricao_pos',$id_inscricao_pos);
					$dados_escolhas['programa_pretendido'] = (int)$request->programa_pretendido;
					$dados_escolhas['area_pos'] = (int)$request->areas_pos;
					$dados_escolhas['interesse_bolsa'] = (bool)$request->interesse_bolsa;
					$dados_escolhas['vinculo_empregaticio'] = (bool)$request->vinculo_empregaticio;
					$atualiza_escolhas->update($dados_escolhas);

				}else{
					$escolhas_candidato = new EscolhaCandidato();
					$escolhas_candidato->id_user = $id_user;
					$escolhas_candidato->programa_pretendido = (int)$request->programa_pretendido;
					$escolhas_candidato->area_pos = (int)$request->areas_pos;
					$escolhas_candidato->interesse_bolsa = (bool)$request->interesse_bolsa;
					$escolhas_candidato->vinculo_empregaticio = (bool)$request->vinculo_empregaticio;
					$escolhas_candidato->id_inscricao_pos = $id_inscricao_pos;
					$escolhas_candidato->save();
				}


				$email_contatos_recomendantes = $request->email_recomendante;

				for ($i=0; $i < count($email_contatos_recomendantes); $i++) { 
					$novo_usuario = new User();
					
					if (is_null($novo_usuario->retorna_user_por_email($email_contatos_recomendantes[$i]))){
						$novo_usuario->email = Purifier::clean(strtolower(trim($email_contatos_recomendantes[$i])));
        				$novo_usuario->password = bcrypt(date("d-m-Y H:i:s:u"));
        				$novo_usuario->user_type =  "recomendante";
        				$novo_usuario->ativo = true;
        				$novo_usuario->save();

        				$dados_recomendantes = new DadoRecomendante();

        				$dados_recomendantes->id_prof = $novo_usuario->id_user;

        				$dados_recomendantes->nome_recomendante = Purifier::clean($request->nome_recomendante[$i]);

        				$dados_recomendantes->save();
					}
					
				}


				$contatos_recomendantes = new ContatoRecomendante();

				$candidato_recomendantes = $contatos_recomendantes->retorna_recomendante_candidato($id_user,$id_inscricao_pos);

				if (count($candidato_recomendantes) > 0) {
					
					$atualiza_recomendantes = ContatoRecomendante::where('id_user', $id_user)->where('id_inscricao_pos',$id_inscricao_pos);

					for ($i=0; $i < count($contatos_recomendantes); $i++) { 
						
						$acha_recomendante = new User();

						$novo_recomendante['id_recomendante'] = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;

						$atualiza_recomendantes->update($novo_recomendante);
					}
				}else{

					for ($i=0; $i < count($email_contatos_recomendantes); $i++) { 
						
						$novo_recomendante = new ContatoRecomendante();
						$acha_recomendante = new User();

						$novo_recomendante->id_user = $id_user;
						$novo_recomendante->id_recomendante = $acha_recomendante->retorna_user_por_email($email_contatos_recomendantes[$i])->id_user;
						$novo_recomendante->id_inscricao_pos = $id_inscricao_pos;

						$novo_recomendante->save();
					}
				}
			}
		}else{
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}
	}
}