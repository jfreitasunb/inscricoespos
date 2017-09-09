<?php

namespace Monitoriamat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Carbon\Carbon;
use Monitoriamat\Models\User;
use Monitoriamat\Models\ConfiguraInscricao;
use Monitoriamat\Models\DisciplinaMat;
use Monitoriamat\Models\DisciplinaMonitoria;
use Monitoriamat\Models\DadoPessoal;
use Monitoriamat\Models\Estado;
use Monitoriamat\Models\DadoBancario;
use Monitoriamat\Models\DadoAcademico;
use Monitoriamat\Models\AtuacaoMonitoria;
use Monitoriamat\Models\EscolhaMonitoria;
use Monitoriamat\Models\HorarioEscolhido;
use Monitoriamat\Models\FinalizaEscolha;
use Monitoriamat\Models\Documento;
use Illuminate\Http\Request;
use Monitoriamat\Mail\EmailVerification;
use Monitoriamat\Http\Controllers\Controller;
use Monitoriamat\Http\Controllers\AuthController;
use Monitoriamat\Http\Controllers\CidadeController;
use Illuminate\Foundation\Auth\RegistersUsers;

use Monitoriamat\Http\Requests;
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

    // public function index()
    // {
    //     $estados = $this->estadoModel->pluck('estado', 'id');

    //     return view('templates.partials.cidade', compact('estados'));
    // }

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

		$estados = $this->estadoModel->pluck('estado', 'id');

		$user = Auth::user();
		$nome = $user->nome;
		$id_user = $user->id_user;
		
		$candidato = new DadoPessoal();
		$dados_pessoais = $candidato->retorna_dados_pessoais($id_user);

		$dados = [
			'nome' => $dados_pessoais->nome,
			'numerorg' => $dados_pessoais->numerorg,
			'emissorrg' => $dados_pessoais->emissorrg,
			'cpf' => $dados_pessoais->cpf,
			'endereco' => $dados_pessoais->endereco,
			'cidade' => $dados_pessoais->cidade,
			'cep' => $dados_pessoais->cep,
			'estado' => $dados_pessoais->estado,
			'telefone' => $dados_pessoais->telefone,
			'celular' => $dados_pessoais->celular,
		];

		return view('templates.partials.candidato.dados_pessoais')->with(compact('estados','dados'));
		
	}

	public function postDadosPessoais(Request $request)
	{
			$this->validate($request, [
				'nome' => 'max:256',
				'numerorg' => 'required|max:21',
				'emissorrg' => 'required|max:201',
				'cpf' => 'required|cpf|numeric',
				'endereco' => 'required|max:256',
				'cidade' => 'required|max:101',
				'cep' => 'required|max:12',
				'estado' => 'required|max:3',
				'telefone' => 'required|max:21',
				'celular' => 'required|max:21',
			]);

			$user = Auth::user();
			$id_user = $user->id_user;
			
			$dados_pessoais = [
				'id_user' => $id_user,
				'numerorg' => $request->input('numerorg'),
				'emissorrg' => $request->input('emissorrg'),
				'cpf' => $request->input('cpf'),
				'endereco' => $request->input('endereco'),
				'cidade' => $request->input('cidade'),
				'cep' => $request->input('cep'),
				'estado' => $request->input('estado'),
				'telefone' => $request->input('telefone'),
				'celular' => $request->input('celular'),
			];

			$candidato =  DadoPessoal::find($id_user);

			if (is_null($candidato)) {
				$cria_candidato = new DadoPessoal();
				$cria_candidato->id_user = $id_user;
				$cria_candidato->nome = $request->input('nome');
				$cria_candidato->numerorg = $request->input('numerorg');
				$cria_candidato->emissorrg = $request->input('emissorrg');
				$cria_candidato->cpf = $request->input('cpf');
				$cria_candidato->endereco = $request->input('endereco');
				$cria_candidato->cidade = $request->input('cidade');
				$cria_candidato->cep = $request->input('cep');
				$cria_candidato->estado = $request->input('estado');
				$cria_candidato->telefone = $request->input('telefone');
				$cria_candidato->celular = $request->input('celular');
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
		
		$monitoria_ativa = new ConfiguraInscricao();
		$ano_semestre_ira = $monitoria_ativa->ira_ano_semestre();

		$dados_academicos = new DadoAcademico();

		$dados_academicos_candidato = $dados_academicos->retorna_dados_academicos($id_user);

		if (is_null($dados_academicos_candidato)) {
			$dados = [];
			return view('templates.partials.candidato.dados_academicos')->with(compact('ano_semestre_ira', 'dados'));
		}else{
			
			$dados = [
				'ira' => str_replace('.', ',', $dados_academicos_candidato->ira),
				'curso_graduacao' => $dados_academicos_candidato->curso_graduacao,
			];
			return view('templates.partials.candidato.dados_academicos')->with(compact('ano_semestre_ira', 'dados'));
		}

		
		
	}

	public function postDadosAcademicos(Request $request)
	{
		$this->validate($request, [
			'ira' => 'required|regex:/^\d+(,\d+)*(\.\d+)?$/|min:0',
			'curso_graduacao' => 'required|max:201',
			'checkbox_foi_monitor' => 'required',
			'arquivo' => 'required|max:20000'
		]);

			$user = Auth::user();
			$id_user = $user->id_user;


			for ($i=0; $i < sizeof($request->checkbox_foi_monitor); $i++) {
				$atuacao = new AtuacaoMonitoria;

				$atuacao->id_user = $id_user;
				$atuacao->atuou_monitoria = $request->checkbox_foi_monitor[$i];

				$atuacao->save();
			}

			$monitoria_ativa = new ConfiguraInscricao();

			$id_monitoria = $monitoria_ativa->retorna_inscricao_ativa()->id_monitoria;
			
			$cria_dados_academicos = new DadoAcademico();
			$cria_dados_academicos->id_user = $id_user;
			$cria_dados_academicos->ira = str_replace(',', '.', $request->input('ira'));
			$cria_dados_academicos->curso_graduacao = $request->input('curso_graduacao');
			$cria_dados_academicos->id_monitoria = $id_monitoria;
			$cria_dados_academicos->save();

			$filename = $request->arquivo->store('documentos');
			$arquivo = new Documento();
			$arquivo->id_user = $id_user;
			$arquivo->nome_arquivo = $filename;
			$arquivo->save();
			
			notify()->flash('Seus dados acadêmicos foram atualizados.','success',[
				'showCancelButton' => false,
				'confirmButtonColor' => '#3085d6',
				'confirmButtonText' => 'OK',
				'notifica' => true,
				'notifica_mensagem' =>'Agora você pode fazer as escolhas das disciplinas para as quais irá se candidatar à Monitoria do MAT.',
				'notifica_tipo' => 'info'
			]);

			return redirect()->route('dados.escolhas');
	}


	/*
/Gravação dos escolhas do Candidato
 */
	public function getEscolhaCandidato()
	{
		$user = Auth::user();
		$id_user = $user->id_user;
		
		$monitoria_ativa = new ConfiguraInscricao();
		$id_monitoria = $monitoria_ativa->retorna_inscricao_ativa()->id_monitoria;
		$autoriza_inscricao = $monitoria_ativa->autoriza_inscricao();
		
		$disciplinas_escolhas = new DisciplinaMonitoria();
		$escolhas = $disciplinas_escolhas->pega_disciplinas_monitoria($id_monitoria);	

		$array_horarios_disponiveis = array('12:00 às 13:00','13:00 às 14:00','18:00 às 19:00');

    
    	$array_dias_semana = array('Segunda-Feira','Terça-Feira','Quarta-Feira','Quinta-Feira','Sexta-Feira');

    	$escolhas_candidato = new EscolhaMonitoria();
		$fez_escolhas = $escolhas_candidato->retorna_escolha_monitoria($id_user,$id_monitoria);
		

		$disable[] = 'disabled="disabled"';

		$finaliza_inscricao = new FinalizaEscolha();

		$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_monitoria);

		if (!$autoriza_inscricao) {

			notify()->flash('O período de inscrição já está encerrado ou ainda não começou.','warning');
			
			return redirect()->route('home');
		}

		if ($status_inscricao) {

			notify()->flash('Você já finalizou sua inscrição. Não é possível fazer novas escolhas de disciplinas para candidatura à Monitoria do MAT.','warning');

			return redirect()->back();
		}

		if (count($fez_escolhas)==3) {
			
			notify()->flash('Você já realizou as 03 (três) escolhas possíveis. Não é possível escolher mais nenhuma disciplina.','error');

			return redirect()->back();
		}else{

			$disable=[];
			$disable[] = '';
			
			return view('templates.partials.candidato.escolha_monitoria')->with(compact('disable','escolhas','array_horarios_disponiveis','array_dias_semana'));
		}
		
	}

	public function postEscolhaCandidato(Request $request)
	{
		$this->validate($request, [
			'escolha_aluno_1' => 'required',
			'mencao_aluno_1' => 'required',
			'monitor_convidado' => 'required',
			'nome_hora_monitoria' => 'required',
			'nome_professor' => 'required_if:monitor_convidado,==,sim',
			'tipo_monitoria' => 'required|is_voluntario:monitor_convidado',
			'concorda_termos' => 'required',

		]);


		$user = Auth::user();
		$id_user = $user->id_user;
		
		$monitoria_ativa = new ConfiguraInscricao();
		$id_monitoria = $monitoria_ativa->retorna_inscricao_ativa()->id_monitoria;
		$autoriza_inscricao = $monitoria_ativa->autoriza_inscricao();

		$finaliza_inscricao = new FinalizaEscolha();

		$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_monitoria);

		$informou_dados_academicos = DadoAcademico::find($id_user);

		if (is_null($informou_dados_academicos)) {
			
			notify()->flash('Por favor informe seus dados acadêmicos antes de efetuar suas escolhas.','warning');

			return redirect()->route('dados.academicos');
		}


		if ($status_inscricao) {
			
			notify()->flash('Você já finalizou sua inscrição. Não é possível fazer novas escolhas de disciplinas para candidatura à Monitoria do MAT.','error');

			return redirect()->route('home');
		}

		if (!$autoriza_inscricao) {

			notify()->flash('O período de inscrição já está encerrado ou ainda não começou.','warning');

			return redirect()->route('home');
		}

		if ($request->input('tipo_monitoria')!== "somentevoluntaria") {
			$informou_banco =  DadoBancario::find($id_user);

			if (is_null($informou_banco)) {

				notify()->flash('Por favor informe seus dados bancários antes de efetuar suas escolhas.','error');

				return redirect()->route('dados.bancarios');
			}

		}


		if (isset($request->nome_professor)) {
			$monitor_projeto = [
				'monitor_convidado' => $request->input('monitor_convidado'),
				'nome_professor' => $request->input('nome_professor'),
			];
		}else{
			$monitor_projeto = [
				'monitor_convidado' => $request->input('monitor_convidado'),
			];
		}

		if (($monitor_projeto['monitor_convidado']) AND ($request->input('tipo_monitoria') != "somentevoluntaria")) {

			notify()->flash('Como você atua em projeto, somente é possível solicitar monitoria voluntária.','warning');
			return redirect()->back();

		}

		$atualiza_dados_academicos = DadoAcademico::where('id_user', '=', $id_user)->where('id_monitoria', '=', $id_monitoria)->first();

		if (is_null($atualiza_dados_academicos)) {

			notify()->flash('Por favor atualize seus dados acadêmicos antes de fazer suas escolhas para a monitoria.','error');

			return redirect()->route('dados.academicos');
		}


		$escolhas = new EscolhaMonitoria();
		$fez_escolhas = $escolhas->retorna_escolha_monitoria($id_user,$id_monitoria);

		
		if (count($fez_escolhas)==0 or count($fez_escolhas)<3) {
			$grava_escolhas = new EscolhaMonitoria();
			$grava_escolhas->id_user = $id_user;
			$grava_escolhas->id_monitoria = $id_monitoria;
			$grava_escolhas->escolha_aluno = $request->input('escolha_aluno_1');
			$grava_escolhas->mencao_aluno = $request->input('mencao_aluno_1');
			$grava_escolhas->save();

			$fez_escolhas = $escolhas->retorna_escolha_monitoria($id_user,$id_monitoria);

			if (isset($request->escolha_aluno_2) and isset($request->mencao_aluno_2) and count($fez_escolhas) < 3) {
				$grava_escolhas = new EscolhaMonitoria();
				$grava_escolhas->id_user = $id_user;
				$grava_escolhas->id_monitoria = $id_monitoria;
				$grava_escolhas->escolha_aluno = $request->input('escolha_aluno_2');
				$grava_escolhas->mencao_aluno = $request->input('mencao_aluno_2');
				$grava_escolhas->save();
			}

			$fez_escolhas = $escolhas->retorna_escolha_monitoria($id_user,$id_monitoria);

			if (isset($request->escolha_aluno_3) and isset($request->mencao_aluno_3) and count($fez_escolhas) < 3) {
				$grava_escolhas = new EscolhaMonitoria();
				$grava_escolhas->id_user = $id_user;
				$grava_escolhas->id_monitoria = $id_monitoria;
				$grava_escolhas->escolha_aluno = $request->input('escolha_aluno_3');
				$grava_escolhas->mencao_aluno = $request->input('mencao_aluno_3');
				$grava_escolhas->save();
			}
		}

		$atualiza_dados_academicos->update($monitor_projeto);
		
		$horario = $request->input('nome_hora_monitoria');

		foreach ($horario as $key) {
			$temp = explode('_', $key);
			$horario_escolhido = new HorarioEscolhido();
			$horario_escolhido->id_user = $id_user;
			$horario_escolhido->horario_monitoria = $temp[1];
			$horario_escolhido->dia_semana = $temp[0];
			$horario_escolhido->id_monitoria = $id_monitoria;

			$horario_escolhido->save();
		}
		
		$finalizar = new FinalizaEscolha();

		$finalizar->id_user = $id_user;
		$finalizar->tipo_monitoria = $request->input('tipo_monitoria');
		$finalizar->concorda_termos = $request->input('concorda_termos');
		$finalizar->id_monitoria = $id_monitoria;

		$finalizar->finalizar = 1;

		$finalizar->save();

		notify()->flash('Suas escolhas foram gravadas com sucesso.','success');

		return redirect()->route('home');

	}



}