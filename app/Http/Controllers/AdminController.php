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

	public function getMenu()
	{	
		echo Session::get('locale');
		return view('home');
	}


	public function getAtivaConta()
	{	
		
		return view('templates.partials.admin.ativa_conta');
	}

	public function postAtivaConta(Request $request)
	{
		
		$this->validate($request, [
			'email' => 'email|max:256',
			'ativar' => 'required',
		]);

		$email = $request->email;
		$ativar_conta = $request->ativar;

		$usuario = new User();
		$user = $usuario->retorna_user_por_email($email);

		if (!is_null($user)) {
			
			$status_usuario = $user->ativo;

			if ($status_usuario) {
				notify()->flash('A conta registrada com o e-mail: '.$email.' já foi ativada!','info');

				return redirect()->route('ativa.conta');
			}else{

				if ($ativar_conta) {
					$user->ativo = TRUE;
					$user->save();

					notify()->flash('A conta registrada com o e-mail: '.$email.' foi ativada com sucesso!','success');

					return redirect()->route('ativa.conta')->with('success','A conta registrada com o e-mail: '.$email.' foi ativada com sucesso!');
				}

			}
		}else{
			notify()->flash('Não existe nenhuma conta registrada com o e-mail: '.$email.'!','error');
			return redirect()->route('ativa.conta');
		}
	}

	public function getPesquisarPapelAtual()
	{
		$dados = null;
		return view('templates.partials.admin.atribuir_papel')->with('dados_usuario', $dados);
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



	public function getCriaCoordenador()
	{
		return view('templates.partials.admin.criar_coordenador');	
	}

	public function postCriaCoordenador(Request $request)
	{

		$this->validate($request, [
			'email' => 'required|unique:users|email',
			'login' => 'required|unique:users',
		]);

		$novo_usuario = new User();

		$novo_usuario->login = $request->input('login');
        $novo_usuario->email = $request->input('email');
        $novo_usuario->password = bcrypt(str_random());
        $novo_usuario->validation_code =  NULL;
        $novo_usuario->user_type = "coordenador";
        $novo_usuario->ativo = TRUE;

        $novo_usuario->save();

        notify()->flash('A conta de coordenador para o e-mail: '.$novo_usuario->email.' foi criada com sucesso!','success');

        return redirect()->route('criar.coordenador');
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

	public function getInscricaoParaReativar(Request $request)
	{
		$this->validate($request, [
			'email_candidato' => 'required|email',
		]);

		$email_candidato = strtolower(trim($request->email_candidato));

		$id_user = $this->getPesquisaCandidato($email_candidato);

		$edital = new ConfiguraInscricaoPos;

		$edital_vigente = $edital->retorna_edital_vigente();

		$finaliza_inscricao = new FinalizaInscricao;

		$finalizou = $finaliza_inscricao->retorna_usuario_inscricao_finalizada($id_user, $id_user);

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


		$finalizada = (int)$request->finalizada;

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

		$candidato['programa'] = $nome_programa_pos->pega_programa_pos_mat($escolha_candidato->programa_pretendido);

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

		// dd($request);


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

		//Falta enviar o e-mail para o novo recomendante.

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


}