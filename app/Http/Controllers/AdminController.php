<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use Posmat\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, RelatorioController, FinalizaInscricao, ContatoRecomendante, DadoRecomendante, DadoPessoal, EscolhaCandidato, CartaRecomendacao};
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CoordenadorController;
use Posmat\Http\Controllers\DataTable\UserController;
use Posmat\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;

/**
* Classe para visualização da página inicial.
*/
class AdminController extends CoordenadorController
{

	protected $unwanted_array = array(    'Š'=>'_', 'š'=>'_', 'Ž'=>'_', 'ž'=>'_', 'À'=>'_', 'Á'=>'_', 'Â'=>'_', 'Ã'=>'_', 'Ä'=>'_', 'Å'=>'_', 'Æ'=>'_', 'Ç'=>'_', 'È'=>'_', 'É'=>'_',
        'Ê'=>'_', 'Ë'=>'_', 'Ì'=>'_', 'Í'=>'_', 'Î'=>'_', 'Ï'=>'_', 'Ñ'=>'_', 'Ò'=>'_', 'Ó'=>'_', 'Ô'=>'_', 'Õ'=>'_', 'Ö'=>'_', 'Ø'=>'_', 'Ù'=>'_',
        'Ú'=>'_', 'Û'=>'_', 'Ü'=>'_', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'_', 'á'=>'_', 'â'=>'_', 'ã'=>'_', 'ä'=>'_', 'å'=>'_', 'æ'=>'_', 'ç'=>'_',
        'è'=>'_', 'é'=>'_', 'ê'=>'_', 'ë'=>'_', 'ì'=>'_', 'í'=>'_', 'î'=>'_', 'ï'=>'_', 'ð'=>'_', 'ñ'=>'_', 'ò'=>'_', 'ó'=>'_', 'ô'=>'_', 'õ'=>'_',
        'ö'=>'_', 'ø'=>'_', 'ù'=>'_', 'ú'=>'_', 'û'=>'_', 'ý'=>'_', 'þ'=>'_', 'ÿ'=>'_', 'Ğ'=>'_', 'İ'=>'_', 'Ş'=>'_', 'ğ'=>'_', 'ı'=>'_', 'ş'=>'_', 'ü'=>'_', 'ă'=>'_', 'Ă'=>'_', 'ș'=>'_', 'Ș'=>'_', 'ț'=>'_', 'Ț'=>'_');

	private $locale_default = 'pt-br';

	private $pesquisa = [
			'nome' => 'Nome',
			'email' => 'E-mail',
		];

	public function getMenu()
	{	
		Session::get('locale');
		return view('home');
	}


	public function getPesquisaConta()
	{	
		$modo_pesquisa = true;

		$tipo_pesquisa = $this->pesquisa;

		return view('templates.partials.admin.ativa_conta')->with(compact('modo_pesquisa', 'tipo_pesquisa'));
	}

	public function getPesquisaLinkMudarSenha()
	{

		$modo_pesquisa = true;

		return view('templates.partials.admin.link_muda_senha')->with(compact('modo_pesquisa'));
	}


	public function postPesquisaLinkMudarSenha(Request $request)
	{

		if ($request->cancelar === 'Limpar'){

			$modo_pesquisa = true;

			return redirect()->route('pesquisa.email.muda.senha');
		}

		$this->validate($request, [
			'email' => 'email|max:256',
		]);

		$email = strtolower(trim($request->email));
		

		$usuario = new User();

		$user = $usuario->retorna_user_por_email($email);

		if (!is_null($user)) {
			
			$modo_pesquisa = false;

			$token_link = str_random(64);

			$url_mudar_senha = url('esqueci/senha').'/'.$token_link;
			$token = (bcrypt($token_link));
			

			DB::table('password_resets')->insert([
				'email' => $user->email,
				'token' => $token,
				'created_at' => Carbon::now(),
			]);

			return view('templates.partials.admin.link_muda_senha')->with(compact('modo_pesquisa', 'user', 'url_mudar_senha'));
		}else{
			notify()->flash('Não existe nenhuma conta registrada com o e-mail: '.$email.'!','error');
			return redirect()->route('pesquisa.usuario');
		}
	}

	public function postPesquisaConta(Request $request)
	{
		
		$tipo_pesquisa = $this->pesquisa;

		$this->validate($request, [
			'campo_pesquisa' => 'required',
		]);

		$pesquisar_pos = $request->tipo_pesquisa;

		$usuario = new User();

		switch ($pesquisar_pos) {
			case 'nome':
				# code...
				break;
			
			default:
				$email = strtolower(trim($request->campo_pesquisa));
				$user = $usuario->retorna_user_por_email($email);
				break;
		}

		if (!is_null($user)) {
			
			$modo_pesquisa = false;

			return view('templates.partials.admin.ativa_conta')->with(compact('modo_pesquisa', 'user', 'tipo_pesquisa'));
		}else{
			notify()->flash('Não existe nenhuma conta registrada com o e-mail: '.$email.'!','error');
			return redirect()->route('pesquisa.usuario');
		}
	}

	public function getPesquisarPapelAtual()
	{
		$dados = null;

		return view('templates.partials.admin.atribuir_papel')->with(compact('dados_usuario'));
	}

	public function postAlteraAtivaConta(Request $request)
	{
		if ($request->cancelar === 'Cancelar'){

			notify()->flash('Alteração da conta cancelada!','info');

			return redirect()->route('pesquisa.usuario');
		}

		$this->validate($request, [
			'email' => 'required|email',
			'id_user' => 'required',
			'locale' => 'required',
			'user_type' => 'required',
			'ativo' => 'required',
		]);

		$id_user = (int)$request->id_user;

		$novos_dados_usuario['email'] = strtolower(trim($request->email));
		$novos_dados_usuario['locale'] = strtolower(trim($request->locale));
		$novos_dados_usuario['validation_code'] = NULL;
		$novos_dados_usuario['user_type'] = strtolower(trim($request->user_type));
		$novos_dados_usuario['ativo'] = (strtolower(trim($request->ativo)) == 'sim' ? 1 : 0);
		
		$atualiza_usuario = User::find($id_user);

		$pesquisa_usuario = new User;

		$pesquisa_email = $pesquisa_usuario->retorna_user_por_email($novos_dados_usuario['email']);

		if (!is_null($pesquisa_email)) {
			if ($atualiza_usuario->email === $pesquisa_email->email) {
				$atualiza_usuario->update($novos_dados_usuario);
			}else{

				notify()->flash('Já existe uma conta registrada com o e-mail: '.$novos_dados_usuario['email'].'!','error');
				return redirect()->back();
			}
		}else{
			$atualiza_usuario->update($novos_dados_usuario);
		}
		
		notify()->flash('Dados atualizados com sucesso!','success');
		
		return redirect()->back();

		
	}

	public function postPesquisarPapelAtual(Request $request)
	{

		$this->validate($request, [
			'email' => 'email|max:256',
		]);

		$email = $request->email;
		
		$usuario = new User();
		$user = $usuario->retorna_user_por_email($email);

		if (!is_null($user)) {

			$papeis_disponiveis = $usuario->retorna_papeis();

			$papel_corrente_usuario = $user->user_type;

			$dados_usuario['email'] = $email;
			$dados_usuario['papel_atual'] = $papel_corrente_usuario;

			return view('templates.partials.admin.atribuir_papel')->with(compact('dados_usuario', 'papeis_disponiveis'));
			
		}else{

			notify()->flash('Não existe nenhuma conta registrada com o e-mail: '.$email.'!','error');

			return redirect()->route('pesquisar.papel');
		}

	}

	public function postAtribuirPapel(Request $request)
	{

		$this->validate($request, [
			'novo_papel' => 'required',
		]);


		$email = $request->email;
		
		$novo_papel = $request->novo_papel;

		$usuario = new User();
		$user = $usuario->retorna_user_por_email($email);

		$dados_usuario = null;
		
		if (!is_null($user)) {

			if ($novo_papel == "admin") {
				
				$user->user_type = "admin";

				$user->save();

				notify()->flash('O usuário: '.$email.' agora é um: '.$novo_papel.'!','warning');

				return redirect()->route('pesquisar.papel');


			}elseif ($novo_papel=="coordenador") {
				
				$user->user_type = "coordenador";
				
				$user->save();

				notify()->flash('O usuário: '.$email.' agora é um: '.$novo_papel.'!','warning');

				return redirect()->route('pesquisar.papel');

			}elseif ($novo_papel=="candidato") {
				
				$user->user_type = "candidato";
				
				$user->save();

				notify()->flash('O usuário: '.$email.' agora é um: '.$novo_papel.'!','warning');

				return redirect()->route('pesquisar.papel');
			}
			
		}else{

			notify()->flash('Não existe nenhuma conta registrada com o e-mail: '.$email.'!','error');
			
			return redirect()->route('pesquisar.papel');
		}

	}

	public function getListaInativos()
	{

		$user = new User;

		$usuarios_inativos = $user->retorna_contas_nao_ativas()->paginate(10);

		return view('templates.partials.admin.lista_inativos')->with(compact('usuarios_inativos'));

	}

	public function postListaInativos(Request $request)
	{
		$id_user = (int) $request->id_user;

		$ativa_usuario = [
			'ativo' => TRUE,
			'$validation_code' => NULL,
		];

		$user = User::find($id_user);

		$status = $user->update($ativa_usuario);

		if ($status) {
			notify()->flash('Conta ativada com sucesso!','success', ['timer' => 1500,]);
			return redirect()->route('lista.inativos');
		}else{
			notify()->flash('Erro ao ativar a conta.','error', ['timer' => 1500,]);
			return redirect()->route('lista.inativos');
		}
		
	}

	public function getEditarInscricao()
	{

		$edital = new ConfiguraInscricaoPos();

      	$edital_vigente = $edital->retorna_edital_vigente();

      	return view('templates.partials.admin.editar_inscricao')->with(compact('edital_vigente'));
	}

	public function postEditarInscricao(Request $request)
	{

		$this->validate($request, [
			'inicio_inscricao' => 'required|date_format:"Y-m-d"|before:fim_inscricao',
			'fim_inscricao' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
			'prazo_carta' => 'required|date_format:"Y-m-d"|after:inicio_inscricao',
			'edital' => 'required',
			'programa' => 'required',
		]);

		$edital_vigente = ConfiguraInscricaoPos::find((int)$request->id_inscricao_pos);

		$novos_dados_edital['inicio_inscricao'] = $request->inicio_inscricao;
		$novos_dados_edital['fim_inscricao'] = $request->fim_inscricao;
		$novos_dados_edital['prazo_carta'] = $request->prazo_carta;
		$novos_dados_edital['programa'] = $request->programa;
		$novos_dados_edital['edital'] = $request->edital;

		$edital_vigente->update($novos_dados_edital);

		notify()->flash('Inscrição alterada com sucesso!','success', ['timer' => 3000,]);

		return redirect()->route('editar.inscricao');
	}

	public function getReativarInscricaoCandidato()
	{

		$modo_pesquisa = true;

		$email_candidato = '';

		return view('templates.partials.admin.reativar_inscricao_candidato')->with(compact('modo_pesquisa', 'email_candidato'));
	}

	public function getPesquisaCandidato($email_candidato)
	{
	
		$user = new User;

		return $user->retorna_user_por_email($email_candidato)->id_user;
	}

	public function postInscricaoParaReativar(Request $request)
	{

		$this->validate($request, [
			'email_candidato' => 'required|email',
		]);

		$email_candidato = strtolower(trim($request->email_candidato));

		$id_user = $this->getPesquisaCandidato($email_candidato);

		$edital = new ConfiguraInscricaoPos;

		$edital_vigente = $edital->retorna_edital_vigente();

		$finaliza_inscricao = new FinalizaInscricao;

		$finalizou = $finaliza_inscricao->retorna_usuario_inscricao_finalizada($edital_vigente->id_inscricao_pos, $id_user, $this->locale_default);

		if (!is_null($finalizou)) {
			

			$modo_pesquisa = false;

			return view('templates.partials.admin.reativar_inscricao_candidato')->with(compact('modo_pesquisa','finalizou','email_candidato'));

		}else{
			
			notify()->flash('O candidato com e-mail: '.$email_candidato.' ainda não finalizou a inscrição!','error');

			$modo_pesquisa = true;

			return view('templates.partials.admin.reativar_inscricao_candidato')->with(compact('modo_pesquisa'));
		}
	}

	public function postReativarInscricaoCandidato(Request $request)
	{
		$this->validate($request, [
			'finalizada' => 'required',
		]);

		$id = (int)$request->id;
		$id_inscricao_pos = (int)$request->id_inscricao_pos;
		$id_user = (int)$request->id_user;
		$email_candidato = $request->email_candidato;


		$finalizada = (strtolower(trim($request->finalizada)) == 'sim' ? 1 : 0);

		if (!$finalizada) {
			$inscricao_finalizada = new FinalizaInscricao;

			DB::table('finaliza_inscricao')->where('id', $id)->where('id_user', $id_user)->where('id_inscricao_pos', $id_inscricao_pos)->update(['finalizada' => 'false', 'updated_at' => date('Y-m-d H:i:s') ]);

			notify()->flash('A inscrição do candidato com e-mail: '.$email_candidato.' foi reativada com sucesso!','success');

			return redirect()->route('reativar.candidato');
		}else{

			notify()->flash('Nenhuma alteração feita na inscrição do candidato: '.$email_candidato,'info');

			return redirect()->route('reativar.candidato');
		}
	}

	public function getPesquisarRecomendantes(){

		$modo_pesquisa = true;
		
		return view('templates.partials.admin.altera_recomendantes_candidato')->with(compact('modo_pesquisa'));
	}

	public function postPesquisarRecomendantes(Request $request)
	{

		$this->validate($request, [
			'email_candidato' => 'required|email',
		]);

		$email_candidato = strtolower(trim($request->email_candidato));

		$id_aluno = $this->getPesquisaCandidato($email_candidato);

		$dados_pessoais = DadoPessoal::find($id_aluno);

		$edital = new ConfiguraInscricaoPos;

		$edital_vigente = $edital->retorna_edital_vigente();

		$id_inscricao_pos = $edital_vigente->id_inscricao_pos;

		$escolha = new EscolhaCandidato;

		$escolha_candidato = $escolha->retorna_escolha_candidato($id_aluno, $id_inscricao_pos);

		$nome_programa_pos = new ProgramaPos();

		$recomendantes = new ContatoRecomendante;

		$indicacoes_candidato = $recomendantes->retorna_recomendante_candidato($id_aluno, $id_inscricao_pos);

		$array_recomendantes = [];

		$candidato = [];

		$candidato['id_inscricao_pos'] = $id_inscricao_pos;

		$candidato['id_aluno'] = $id_aluno;

		$candidato['nome'] = $dados_pessoais->nome;

		$candidato['programa'] = $nome_programa_pos->pega_programa_pos_mat($escolha_candidato->programa_pretendido, $this->locale_default);

		$candidato['edital'] = $edital_vigente->edital;

		foreach ($indicacoes_candidato as $indicacao) {
			
			$dados_pessoais_recomendante = new DadoRecomendante;

			$array_recomendantes[$indicacao->id_recomendante]['id'] = $indicacao->id;

			$array_recomendantes[$indicacao->id_recomendante]['nome_recomendante'] = $dados_pessoais_recomendante->retorna_dados_pessoais_recomendante($indicacao->id_recomendante)->nome_recomendante;

			$array_recomendantes[$indicacao->id_recomendante]['email_recomendante'] = User::find($indicacao->id_recomendante)->email;
		}

		$modo_pesquisa = false;

		return view('templates.partials.admin.altera_recomendantes_candidato')->with(compact('array_recomendantes', 'candidato', 'modo_pesquisa'));

	}

	public function postAlteraRecomendante(Request $request)
	{

		
		if ($request->cancelar === 'Cancelar'){

			notify()->flash('Alteração dos recomendantes cancelada!','info');

			return redirect()->route('pesquisa.recomendantes');
		}

		$this->validate($request, [
			'id' => 'required',
			'id_aluno' => 'required',
			'id_inscricao_pos' => 'required',
			'id_recomendante' => 'required',
			'id_recomendante' => 'required',
			'nome_recomendante' => 'required',
			'email_recomendante' => 'required|email',
		]);


		$id = (int)$request->id;
		$id_aluno = (int)$request->id_aluno;
		$id_inscricao_pos = (int)$request->id_inscricao_pos;
		$id_recomendante = (int)$request->id_recomendante;
		$email_recomendante = strtolower(trim($request->email_recomendante));
		$nome_recomendante = trim($request->nome_recomendante);
		$email_candidato = strtolower(trim($request->email_candidato));

		$user_recomendante = new User;

		$acha_recomendante = $user_recomendante->retorna_user_por_email($email_recomendante);

		if (is_null($acha_recomendante)) {
			$novo_usuario = new User();
            $novo_usuario->email = $email_recomendante;
            $novo_usuario->password = bcrypt(date("d-m-Y H:i:s:u"));
            $novo_usuario->user_type =  "recomendante";
            $novo_usuario->ativo = true;
            $novo_usuario->save();

            $id_novo_recomendante = $novo_usuario->id_user;
            
            $dados_iniciais_recomendante = new DadoRecomendante();

            $grava_dados_inicias = $dados_iniciais_recomendante->grava_dados_iniciais_recomendante($id_novo_recomendante, $nome_recomendante);

		}else{

			if ($acha_recomendante->user_type === 'recomendante') {
				$id_novo_recomendante = $acha_recomendante->id_user;
			}else{

				notify()->flash('O e-mail: '.$email_recomendante.' pertence a um candidato!','error');
				return redirect()->back();
			}	
		}

		$mudou_recomendante = DB::table('cartas_recomendacoes')->where('id_aluno', $id_aluno)->where('id_inscricao_pos', $id_inscricao_pos)->where('id_prof', $id_recomendante)->where('completada', false)->update(['id_prof' => $id_novo_recomendante, 'updated_at' => date('Y-m-d H:i:s') ]);

		if (!$mudou_recomendante) {
			
			notify()->flash('O recomendante original já enviou a carta. Não é possível trocar!','error');
			return redirect()->back();
			
		}

		DB::table('contatos_recomendantes')->where('id', $id)->where('id_user', $id_aluno)->where('id_inscricao_pos', $id_inscricao_pos)->where('id_recomendante', $id_recomendante)->update(['id_recomendante' => $id_novo_recomendante, 'updated_at' => date('Y-m-d H:i:s') ]);

		$edital = ConfiguraInscricaoPos::find($id_inscricao_pos);

		$prazo_envio = Carbon::createFromFormat('Y-m-d', $edital->prazo_carta);

		$dados_email['nome_professor'] = $nome_recomendante;
        $dados_email['nome_candidato'] = $request->nome_candidato;
		$dados_email['programa'] = $request->programa;
        $dados_email['email_recomendante'] = $email_recomendante;
        $dados_email['prazo_envio'] = $prazo_envio->format('d/m/Y');

		Notification::send(User::find($id_novo_recomendante), new NotificaRecomendante($dados_email));

		notify()->flash('Alteração efetuado com sucesso','success');

		return redirect()->back();

	}

	public function getPesquisarCartaEnviada()
	{

		$modo_pesquisa = true;

		return view('templates.partials.admin.reativar_carta_finalizada')->with(compact('modo_pesquisa'));
	}

	public function postPesquisarCartaEnviada(Request $request)
	{

		$this->validate($request, [
			'email_recomendante' => 'required|email',
		]);

		$email_recomendante = strtolower(trim($request->email_recomendante));

		$user = new User;

		$usuario_pesquisado = $user->retorna_user_por_email($email_recomendante);

		if ($usuario_pesquisado->user_type <> "recomendante") {
			
			notify()->flash('O e-mail informado '.$email_recomendante.' não pertence a um recomendante.','info');

			return redirect()->route('pesquisa.carta');

		}

		$id_recomendante = $this->getPesquisaCandidato($email_recomendante);

		$dados_pessoais = DadoPessoal::find($id_recomendante);

		$edital = new ConfiguraInscricaoPos;

		$edital_vigente = $edital->retorna_edital_vigente();

		$id_inscricao_pos = $edital_vigente->id_inscricao_pos;

		$cartas_recomendacoes = new CartaRecomendacao;


		$modo_pesquisa = false;

		$cartas_completadas = $cartas_recomendacoes->retorna_cartas_para_reativar($id_recomendante, $id_inscricao_pos, $this->locale_default);

		
		return view('templates.partials.admin.reativar_carta_finalizada')->with(compact('modo_pesquisa', 'cartas_completadas'));
	}

	public function postReativarCartaEnviada(Request $request)
	{
		if ($request->cancelar === 'Cancelar'){

			notify()->flash('Alteração das cartas cancelada!','info');

			return redirect()->route('pesquisa.carta');
		}

		$this->validate($request, [
			'id_inscricao_pos' => 'required',
			'id_aluno' => 'required',
			'id_recomendante' => 'required',
			'completada' => 'required',
		]);

		$id_inscricao_pos = (int)$request->id_inscricao_pos;
		$id_aluno = (int)$request->id_aluno;
		$id_recomendante = (int)$request->id_recomendante;
		$completada = (strtolower(trim($request->completada)) == 'sim' ? 1 : 0);

		$carta_recomendacao = new CartaRecomendacao;

		$carta_recomendacao->reativa_carta_finalizada($id_inscricao_pos, $id_aluno, $id_recomendante, $completada);

		notify()->flash('Alteração efetuado com sucesso','success');

		return redirect()->back();
	}

	public function getAchaIndicacoes()
	{

		$modo_pesquisa = true;

		return view('templates.partials.admin.acha_indicacoes')->with(compact('modo_pesquisa'));
	}

	public function postAchaIndicacoes(Request $request)
	{

		$this->validate($request, [
			'email_recomendante' => 'required|email',
		]);
		
		$user = new User;
		
		$email_recomendante = trim(strtolower($request->email_recomendante));

		$recomendante = $user->retorna_user_por_email($email_recomendante);

		if (is_null($recomendante)) {
			
			notify()->flash('O e-mail: '.$email_recomendante.' não pertence a um recomendante registrado no sistema.','error');

			return redirect()->route('pesquisa.indicacoes');
		}

		$contato_recomendante = new ContatoRecomendante;

		
		if (sizeof($contato_recomendante->retorna_candidatos_por_recomendante($recomendante->id_user, $this->locale_default)) == 0) {
			
			notify()->flash('O e-mail: '.$email_recomendante.' não foi indicado por nenhum candidato no edital atual.','error');

			return redirect()->route('pesquisa.indicacoes');
		}

		$indicacoes = $contato_recomendante->retorna_candidatos_por_recomendante($recomendante->id_user, $this->locale_default);

		$modo_pesquisa = false;

		return view('templates.partials.admin.acha_indicacoes')->with(compact('modo_pesquisa', 'indicacoes'));
	}

	public function getListaIndicacoes()
	{
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();


		$finalizacoes = new FinalizaInscricao;
		

		$inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos, $this->locale_default)->paginate(10);

		$dados_para_template = [];

		foreach ($inscricoes_finalizadas as $inscricao) {

			$recomendante_candidato = new ContatoRecomendante();

			$recomendantes_candidato = $recomendante_candidato->retorna_recomendante_candidato($inscricao->id_user,$inscricao->id_inscricao_pos);

			$dados_para_template[$inscricao->id_user]['nome_candidato'] = $inscricao->nome;
			$dados_para_template[$inscricao->id_user]['tipo_programa_pos'] = $inscricao->tipo_programa_pos_ptbr;
			$i = 1;
			foreach ($recomendantes_candidato as $recomendante) {


				$dado_pessoal_recomendante = new DadoRecomendante();

				$usuario_recomendante = User::find($recomendante->id_recomendante);

				$dados_para_template[$inscricao->id_user]['email_recomendante_'.$i] = $usuario_recomendante->email;

				$dados_para_template[$inscricao->id_user]['nome_recomendante_'.$i] = $dado_pessoal_recomendante->retorna_dados_pessoais_recomendante($recomendante->id_recomendante)->nome_recomendante;

				$carta_recomendacao = new CartaRecomendacao();
				
				$carta_aluno = $carta_recomendacao->retorna_carta_recomendacao($recomendante->id_recomendante,$inscricao->id_user,$inscricao->id_inscricao_pos);

				$dados_para_template[$inscricao->id_user]['status_carta_'.$i] = $carta_aluno->completada;

				$i++;
			}
		}
		
		// dd($dados_para_template);
		return view('templates.partials.admin.tabela_indicacoes')->with(compact('dados_para_template', 'inscricoes_finalizadas'));
	}

	public function postListaIndicacoes(Request $request)
	{
		
	}
}