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
use Posmat\Models\AssociaEmailsRecomendante;
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
use Posmat\Models\Paises;
use Posmat\Models\Cidade;
use Posmat\Notifications\NotificaRecomendante;
use Posmat\Notifications\NotificaCandidato;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Posmat\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

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
		Session::get('locale');
		
		return view('home');
	}

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
		
		$candidato = new DadoPessoal();
		$dados_pessoais = $candidato->retorna_dados_pessoais($id_user);

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
			'nome' => $dados_pessoais->nome,
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
			
			$id_user = $user->id_user;

    		$nascimento = Carbon::createFromFormat('d/m/Y', Purifier::clean(trim($request->data_nascimento)));

    		$data_nascimento = $nascimento->format('Y-m-d');
    	
			$dados_pessoais = [
				'id_user' => $id_user,
				'nome' => Purifier::clean(trim($request->input('nome'))),
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


			notify()->flash('Seus dados pessoais foram atualizados.','success');

			$edital_ativo = new ConfiguraInscricaoPos();

			$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
			$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
			$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if ($autoriza_inscricao and !$status_inscricao) {
				return redirect()->route('dados.academicos');
			}else{

				return redirect()->back();

			}
	}

/*
/Gravação dos dados Acadêmicos
 */
	public function getDadosAcademicos()
	{
		$user = $this->SetUser();
		
		$id_user = $user->id_user;
		
		$locale_candidato = Session::get('locale');

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

		$dados_academicos = new DadoAcademico();

		$tipo_formacao = new Formacao();

		$graduacao = $tipo_formacao->where('nivel','Graduação')->whereNotNull($nome_coluna)->pluck($nome_coluna,'id')->prepend(trans('mensagens_gerais.selecionar'),'');

		$pos = $tipo_formacao->where('nivel','Pós-Graduação')->whereNotNull($nome_coluna)->pluck($nome_coluna,'id')->prepend(trans('mensagens_gerais.selecionar'),'');;

		$dados_academicos_candidato = $dados_academicos->retorna_dados_academicos($id_user);

		$nivel_candidato[0] = 'Especialista';
		$nivel_candidato[1] = 'Mestrado';
		$nivel_candidato[2] = 'Doutorado';


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
			return view('templates.partials.candidato.dados_academicos')->with(compact('dados', 'graduacao', 'nivel_candidato','pos'));
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


			return view('templates.partials.candidato.dados_academicos')->with(compact('dados', 'graduacao', 'nivel_candidato', 'pos'));
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
		
		$id_user = $user->id_user;
		
		$formacao = new Formacao;

		$nivel_candidato[0] = 'Especialista';
		$nivel_candidato[1] = 'Mestrado';
		$nivel_candidato[2] = 'Doutorado';

		$dados_academicos = DadoAcademico::find($id_user);

		$cria_dados_academicos['curso_graduacao'] = Purifier::clean(trim($request->input('curso_graduacao')));
		$cria_dados_academicos['tipo_curso_graduacao'] = (int)Purifier::clean(trim($request->input('tipo_curso_graduacao')));
		$cria_dados_academicos['instituicao_graduacao'] = Purifier::clean(trim($request->input('instituicao_graduacao')));
		$cria_dados_academicos['ano_conclusao_graduacao'] = (int)Purifier::clean(trim($request->input('ano_conclusao_graduacao')));
		$cria_dados_academicos['curso_pos'] = Purifier::clean(trim($request->input('curso_pos')));
		// $cria_dados_academicos['nivel_pos'] = $formacao->retorna_id_formacao($nivel_candidato[(int)$request->nivel_pos],'Pós-Graduação');
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
			// $cria_dados_academicos->nivel_pos = $formacao->retorna_id_formacao($nivel_candidato[(int)$request->nivel_pos],'Pós-Graduação');
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
		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$locale_candidato = Session::get('locale');
		
		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			$programas_disponiveis = explode("_", $edital_ativo->retorna_inscricao_ativa()->programa);

			$nome_programa_pos = new ProgramaPos();


			foreach ($programas_disponiveis as $programa) {
				$programa_para_inscricao[$programa] = $nome_programa_pos->pega_programa_pos_mat($programa, $locale_candidato);
			}

			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			$dados = [];
			$dados['programa_pretendido'] = null;
			$dados['area_pos'] = null;
			$dados['interesse_bolsa'] = null;
			$dados['vinculo_empregaticio'] = null;
					
			$dados['nome_recomendante_1'] = null;
			$dados['nome_recomendante_2'] = null;
			$dados['nome_recomendante_3'] = null;
			$dados['email_recomendante_1'] = null;
			$dados['email_recomendante_2'] = null;
			$dados['email_recomendante_3'] = null;
			$dados['nome_recomendante_1'] = null;
			$dados['nome_recomendante_2'] = null;
			$dados['nome_recomendante_3'] = null;
			$dados['email_recomendante_1'] = null;
			$dados['email_recomendante_2'] = null;
			$dados['email_recomendante_3'] = null;

			$escolha_candidato = new EscolhaCandidato();

			$candidato_ja_escolheu = $escolha_candidato->retorna_escolha_candidato($id_user, $id_inscricao_pos);

			if (!is_null($candidato_ja_escolheu)) {

					$canditato_recomendante = new ContatoRecomendante();

					$contatos_recomendantes = $canditato_recomendante->retorna_recomendante_candidato($id_user,$id_inscricao_pos);

					if (count($contatos_recomendantes) > 0) {
						$i = 1;
						foreach ($contatos_recomendantes as $recomendante) {
					
							$usuario_recomendante = User::find($recomendante->id_recomendante);
						
							$dado_recomendante = new DadoRecomendante();

							$dados_recomendante = $dado_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante);
						
							$dados['email_recomendante_'.$i] = $usuario_recomendante->email;
						
							$dados['nome_recomendante_'.$i] = $dados_recomendante->nome_recomendante;

							$i++;
						}
					}

					$dados['programa_pretendido'] = $candidato_ja_escolheu->programa_pretendido;
					$dados['area_pos'] = $candidato_ja_escolheu->area_pos;
					$dados['interesse_bolsa'] = $candidato_ja_escolheu->interesse_bolsa;
					$dados['vinculo_empregaticio'] = $candidato_ja_escolheu->vinculo_empregaticio;
				}

			if (in_array(2, $programas_disponiveis)) {

				switch ($locale_candidato) {
				 	case 'en':
				 		$nome_coluna = 'nome_en';
				 		break;

				 	case 'es':
				 		$nome_coluna = 'nome_es';
				 		break;
				 	
				 	default:
				 		$nome_coluna = 'nome_ptbr';
				 		break;
				 }

				$areas_pos = AreaPosMat::pluck($nome_coluna,'id_area_pos')->prepend(trans('mensagens_gerais.selecionar'),'');
			}
			
			return view('templates.partials.candidato.escolha_candidato')->with(compact('disable','programa_para_inscricao','areas_pos','dados'));

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

		$user = $this->SetUser();
		
		$id_aluno = $user->id_user;
		
		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_aluno,$id_inscricao_pos);

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

				if (!is_null($request->areas_pos) and $request->programa_pretendido === '2') {
					
					notify()->flash(trans('mensagens_gerais.informe_area'),'warning');

					return redirect()->back();
				}


				
				$escolhas_candidato = new EscolhaCandidato();

				$registra_escolhas_candidato = $escolhas_candidato->grava_escolhas_candidato($id_aluno,$id_inscricao_pos,$request);


				$email_contatos_recomendantes = [];

				for ($i=0; $i < count($request->email_recomendante); $i++) { 
					
					$email_contatos_recomendantes[$i] = Purifier::clean(strtolower(trim($request->email_recomendante[$i])));

					$associa_email = new AssociaEmailsRecomendante;

					$existe_associacao = $associa_email->retorna_associacao($email_contatos_recomendantes[$i]);

					if (!is_null($existe_associacao)) {
						$email_contatos_recomendantes[$i] = $existe_associacao;
					}
				}


				$novo_usuario = new User();
				$array_erro = [];

				for ($i=0; $i < count($email_contatos_recomendantes); $i++) { 
					$novo_usuario_recomendante = $novo_usuario->registra_recomendante($email_contatos_recomendantes[$i]);

					if ($novo_usuario_recomendante) {
						$array_erro[$i] = $email_contatos_recomendantes[$i];
					}
				}

				if (!empty($array_erro)) {
					notify()->flash(trans('mensagens_gerais.inicio_erro_email_recomendantes').implode(", ", $array_erro).trans('mensagens_gerais.final_erro_email_recomendantes'),'warning');
					return redirect()->back();
				}
				
				$dados_iniciais_recomendante = new DadoRecomendante();

				for ($j=0; $j < count($email_contatos_recomendantes); $j++) {

					$id_recomendante = $novo_usuario->retorna_user_por_email($email_contatos_recomendantes[$j]);
					
					$grava_dados_inicias = $dados_iniciais_recomendante->grava_dados_iniciais_recomendante($id_recomendante->id_user, Purifier::clean($request->nome_recomendante[$j]));
				}


				$contatos_recomendantes = new ContatoRecomendante();

				$candidato_recomendantes = $contatos_recomendantes->processa_indicacoes($id_aluno, $id_inscricao_pos, $email_contatos_recomendantes);

				$carta_recomendacao = new CartaRecomendacao();

				$inicia_carta = $carta_recomendacao->inicia_carta_candidato($id_aluno, $id_inscricao_pos, $email_contatos_recomendantes);

			}
			
			notify()->flash(trans('mensagens_gerais.mensagem_sucesso'),'success');
			
			return redirect()->route('motivacao.documentos');
		}else{
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}
	}


/*
/Gravação dos dados Bancários
 */

	public function getMotivacaoDocumentos()
	{
		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		$arquivos_editais = "storage/editais/";
	
		if ($autoriza_inscricao) {
		
			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}else{

				$motivacao = new CartaMotivacao();

				$fez_carta_motivacao = $motivacao->retorna_carta_motivacao($id_user,$id_inscricao_pos);

				if (is_null($fez_carta_motivacao)) {
					$dados['motivacao'] = '';

					return view('templates.partials.candidato.motivacao_documentos',compact('arquivos_editais','edital', 'dados'));
				}else{

					$dados['motivacao'] = $fez_carta_motivacao->motivacao;

					return view('templates.partials.candidato.motivacao_documentos',compact('arquivos_editais','edital','dados'));
				}
				
			}
		}else{
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}
	}

	public function postMotivacaoDocumentos(Request $request)
	{
		$this->validate($request, [
			'motivacao' => 'required',
			'documentos_pessoais' => 'required|max:20000',
			'historico' => 'required|max:20000',
			'concorda_termos' => 'required',
		]);

			$user = $this->SetUser();
			
			$id_user = $user->id_user;

			$edital_ativo = new ConfiguraInscricaoPos();

			$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
			
			$doc_pessoais = $request->documentos_pessoais->store('uploads');
			$arquivo = new Documento();
			$arquivo->id_user = $id_user;
			$arquivo->nome_arquivo = $doc_pessoais;
			$arquivo->tipo_arquivo = "Documentos";
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
			$arquivo->save();

			$hist = $request->historico->store('uploads');
			$arquivo = new Documento();
			$arquivo->id_user = $id_user;
			$arquivo->nome_arquivo = $hist;
			$arquivo->tipo_arquivo = "Histórico";
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
			$arquivo->save();

			$motivacao = new CartaMotivacao();

			$carta_motivacao = $motivacao->retorna_carta_motivacao($id_user, $id_inscricao_pos);

			if (count($carta_motivacao)==0) {
				$nova_motivacao = new CartaMotivacao();
				$nova_motivacao->id_user = $id_user;
				$nova_motivacao->motivacao = Purifier::clean($request->input('motivacao'));
				$nova_motivacao->concorda_termos = (bool)$request->input('concorda_termos');
				$nova_motivacao->id_inscricao_pos = $id_inscricao_pos;
				$nova_motivacao->save();
			}else{
				$dados_motivacao['motivacao'] = Purifier::clean($request->input('motivacao'));
				$dados_motivacao['updated_at'] = date('Y-m-d H:i:s');
				
				DB::table('carta_motivacoes')->where('id_user', $id_user)->where('id_inscricao_pos', $id_inscricao_pos)->update($dados_motivacao);
			}

			notify()->flash(trans('mensagens_gerais.mensagem_sucesso'),'success');

			return redirect()->route('finalizar.inscricao');		
	}


	public function getFinalizarInscricao(){

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$locale_candidato = Session::get('locale');

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();
		$arquivos_editais = storage_path("/app/editais/");

		if ($autoriza_inscricao) {


			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			$dados_pessoais = new DadoPessoal();

			$dados_pessoais_candidato = $dados_pessoais->retorna_dados_pessoais($id_user);

			$nome_candidato = $dados_pessoais_candidato->nome;

			if (is_null($dados_pessoais_candidato->data_nascimento)) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_dados_pessoais'),'warning');

				return redirect()->route('dados.pessoais');
			}
			
			$novo_relatorio = new RelatorioController;

			$ficha_inscricao = $novo_relatorio->geraFichaInscricao($id_user, $id_inscricao_pos, $locale_candidato);


			return view('templates.partials.candidato.finalizar_inscricao',compact('ficha_inscricao','nome_candidato'));

		}else{
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}


		
	}

	public function postFinalizarInscricao(Request $request){

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$locale_fixo = 'en';

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if ($status_inscricao) {
				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			$informou_dados_academicos = DadoAcademico::find($id_user);


			if (is_null($informou_dados_academicos)) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_dados_academicos'),'warning');

				return redirect()->route('dados.academicos');
			}

			$informou_escolha = new EscolhaCandidato();

			$escolheu = $informou_escolha->retorna_escolha_candidato($id_user,$id_inscricao_pos);

			if (count($informou_escolha) == 0) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_escolha'),'warning');

				return redirect()->route('dados.escolhas');
			}

			$recomendantes_candidato = new ContatoRecomendante();

			$informou_recomendantes = $recomendantes_candidato->retorna_recomendante_candidato($id_user,$id_inscricao_pos);


			if (count($informou_recomendantes) < 3) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_recomendante'),'warning');

				return redirect()->route('dados.escolhas');
			}

			$informou_motivacao = new CartaMotivacao();

			$fez_carta_motivacao = $informou_motivacao->retorna_carta_motivacao($id_user, $id_inscricao_pos);

			if (count($fez_carta_motivacao) == 0) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_motivacao'),'warning');

				return redirect()->route('motivacao.documentos');
			}

			$documentos = new Documento();

			$enviou_historico = $documentos->retorna_historico($id_user, $id_inscricao_pos);

			$enviou_documentos = $documentos->retorna_documento($id_user, $id_inscricao_pos);

			if (count($enviou_historico) == 0 or count($enviou_documentos) == 0) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_documentos'),'warning');

				return redirect()->route('motivacao.documentos');
			}

			$dado_pessoal_candidato = new DadoPessoal();

			$dados_pessoais_candidato = $dado_pessoal_candidato->retorna_dados_pessoais($id_user);

			$escolha_candidato = new EscolhaCandidato();

			$programa_pretendido = $escolha_candidato->retorna_escolha_candidato($id_user,$id_inscricao_pos)->programa_pretendido;
			$programa_pos = new ProgramaPos();

			$nome_programa_pos_candidato = $programa_pos->pega_programa_pos_mat($programa_pretendido, $locale_fixo);

			$dados_email_candidato['nome_candidato'] = $dados_pessoais_candidato->nome;
			$dados_email_candidato['programa'] = $nome_programa_pos_candidato;

			foreach ($informou_recomendantes as $recomendante) {
				
				if (!$recomendante->email_enviado) {

					$dado_pessoal_recomendante = new DadoRecomendante();


					$prazo_envio = Carbon::createFromFormat('Y-m-d', $edital_ativo->retorna_inscricao_ativa()->prazo_carta);

					$dados_email['nome_professor'] = $dado_pessoal_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome_recomendante;
        			$dados_email['nome_candidato'] = $dados_pessoais_candidato->nome;
			        $dados_email['programa'] = $nome_programa_pos_candidato;
        			$dados_email['email_recomendante'] = User::find($recomendante->id_recomendante)->email;
        			$dados_email['prazo_envio'] = $prazo_envio->format('d/m/Y');

					Notification::send(User::find($recomendante->id_recomendante), new NotificaRecomendante($dados_email));

					DB::table('contatos_recomendantes')->where('id', $recomendante->id)->where('id_user', $recomendante->id_user)->where('id_inscricao_pos', $recomendante->id_inscricao_pos)->update(['email_enviado' => 'true']);

				}
			}
			

			$dados_email_candidato['ficha_inscricao'] = $request->ficha_inscricao;
			
			Notification::send(User::find($id_user), new NotificaCandidato($dados_email_candidato));

			$finalizar_inscricao = new FinalizaInscricao();

			$id_finalizada_anteriormente = $finalizar_inscricao->select('id')->where('id_user',$id_user)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');

			if (count($id_finalizada_anteriormente)>0){

				DB::table('finaliza_inscricao')->where('id', $id_finalizada_anteriormente[0])->where('id_user', $id_user)->where('id_inscricao_pos', $id_inscricao_pos)->update(['finalizada' => True]);
			}else{
				
				$finalizar_inscricao->id_user = $id_user;
				$finalizar_inscricao->id_inscricao_pos = $id_inscricao_pos;
				$finalizar_inscricao->finalizada = true;
				$finalizar_inscricao->save();
			}



			notify()->flash(trans('mensagens_gerais.envio_final'),'success');

			return redirect()->route('home');

		}
	}

	public function getStatusCartas(){

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if (!$status_inscricao) {

				return redirect()->back();
			}

			$recomendante_candidato = new ContatoRecomendante();

			$recomendantes_candidato = $recomendante_candidato->retorna_recomendante_candidato($id_user,$id_inscricao_pos);
			
			$dados_para_template = [];

			foreach ($recomendantes_candidato as $recomendante) {

				$dado_pessoal_recomendante = new DadoRecomendante();

				$dados_para_template[$recomendante->id_recomendante]['nome_recomendante'] = $dado_pessoal_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome_recomendante;

				$carta_recomendacao = new CartaRecomendacao();
				
				$carta_aluno = $carta_recomendacao->retorna_carta_recomendacao($recomendante->id_recomendante,$id_user,$id_inscricao_pos);

				$dados_para_template[$recomendante->id_recomendante]['status_carta'] = $carta_aluno->completada;

			}
			

			return view('templates.partials.candidato.status_cartas',compact('dados_para_template'));

		}else{
			return redirect()->back();
		}
	}
}