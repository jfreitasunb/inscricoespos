<?php

namespace Monitoriamat\Http\Controllers\Auth;

use Auth;
use DB;
use Mail;
use Session;
use Monitoriamat\Models\User;
use Monitoriamat\Models\Monitoria;
use Monitoriamat\Models\DadoPessoal;
use Illuminate\Http\Request;
use Monitoriamat\Mail\EmailVerification;
use Monitoriamat\Http\Controllers\Controller;
use Monitoriamat\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Monitoriamat\Notifications\AtivaConta;



/**
* Classe para visualização da página inicial.
*/
class AuthController extends BaseController
{

	public function getSignup()
	{	
		return view('auth.registrar');
	}

	public function postSignup( Request $request)
	{

		$STRING_VALIDA_EMAIL = "EsN7Qh2G#U(i24g@LQ=^=NMX74CmuVYZmAPNW?nE3ss6hxtUnvLZBjbD.V[7Y,8LW6trtj%CZWKr^aREKgm]QYW@87xZW4]CEK4mT[yz*o&t6VvzT,E2BGx2j2BP7%Jo{EkRM2Z=Pa4qWu4GeT83)pA]9*rHYctr}L4ka[c6YiweZq=Q>m$7tfPBQoW8wgFm86k8[iDu?HBA[9kiRJeH)7QGnND6oFAbD2Vq(2acX+TAmQbMq3jPUVJ,JPaA]9.)"; /*string usada para gerar o código de validação do e-mail. Deve ser grande por questões de segurança.*/

		$this->validate($request,[
			'nome' => 'required|max:255',
			'login'  => 'required|unique:users|max:255',
			'email'  => 'required|unique:users|email|max:255',
			'confirmar-email'  => 'required|email|same:email|max:255',
			'password'  => 'required|min:1',
			'confirmar-password'  => 'required|same:password|min:1',

		]);

		$novo_usuario = new User();


		$novo_usuario->login = $request->input('login');
        $novo_usuario->email = $request->input('email');
        $novo_usuario->password = bcrypt($request->input('password'));
        $novo_usuario->validation_code =  md5($STRING_VALIDA_EMAIL.$request->input('email').date("d-m-Y H:i:s:u"));

        $novo_usuario->save();
		
		$id_user = $novo_usuario->id_user;

		$cria_candidato = new DadoPessoal();
		$cria_candidato->id_user = $id_user;
		$cria_candidato->nome = $request->input('nome');
		$cria_candidato->save();

		


		Notification::send(User::find($id_user), new AtivaConta($novo_usuario->validation_code));


		notify()->flash('Conta criada com sucesso. Foi enviado para o e-mail: '.$novo_usuario->email.' um link de ativação da sua conta. Somente após ativação você conseguirá fazer login no sistema.','info');

		return redirect()->route('home');

	}

	public function getLogin()
	{	
		return view('auth.login');
	}

	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'login' => 'required',
			'password' => 'required',
		]);

		
		$user = DB::table('users')->where('login', $request->input('login'))->value('ativo');

		if (!$user) {
			notify()->flash('Você não ativou sua conta ainda. Você deve clicar no link de ativação que foi enviado para seu e-mail.','info');
			return redirect()->back();
		}else{
			if (!Auth::attempt($request->only(['login', 'password']))) {
				notify()->flash('Usuário ou senha não conferem!', 'error',[
					'timer' => 3000,
				]);
				return redirect()->back();
			}
		}

		$user_type = DB::table('users')->where('login', $request->input('login'))->value('user_type');

		Session::put('user_type', $user_type);

		if ($user_type === 'coordenador') {
			notify()->flash('Bem vindo!','success',[
				'timer' => 1500,
			]);
			return redirect()->intended('coordenador');
		}
		
		if ($user_type === 'admin') {
			notify()->flash('Bem vindo!','success',[
				'timer' => 1500,
			]);
			return redirect()->intended('admin');
		}

		if ($user_type === 'aluno') {
			notify()->flash('Bem vindo!','success',[
				'timer' => 1500,
			]);
			return redirect()->intended('aluno');
		}

		notify()->flash('Você não se identificou ainda.','warning',[
				'timer' => 1500,
			]);
		return redirect()->route('home');
	}

	public function getLogout()
	{
		Auth::logout();

		notify()->flash('Você saiu da sua conta.','info',[
				'timer' => 1500,
			]);

		return redirect()->route('home');
	}

	public function getMudouSenha()
	{
		Auth::logout();

		notify()->flash('Senha alterada com sucesso!','success',[
				'timer' => 1500,
			]);

		return redirect()->route('home');
	}

	public function verify($token)
	{
	    // The verified method has been added to the user model and chained here
	    // for better readability
	    User::where('validation_code',$token)->firstOrFail()->verified();

	    notify()->flash('Conta ativada com sucesso!','success',[
				'timer' => 1500,
			]);

	    return redirect()->route('home');
	}

	
}