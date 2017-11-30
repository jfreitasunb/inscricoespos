<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Carbon\Carbon;
use Posmat\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPosMat, RelatorioController, FinalizaInscricao};
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CoordenadorController;
use Posmat\Http\Controllers\DataTable\UserController;
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

		$email_candidato = trim($request->email_candidato);

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


}