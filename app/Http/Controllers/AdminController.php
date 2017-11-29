<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\ProgramaPosMat;
use Posmat\Models\RelatorioController;
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

}