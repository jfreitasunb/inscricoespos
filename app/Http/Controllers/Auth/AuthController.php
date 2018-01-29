<?php

namespace Posmat\Http\Controllers\Auth;

use Auth;
use DB;
use Mail;
use Session;
use Purifier;
use Posmat\Models\User;
use Posmat\Models\Monitoria;
use Posmat\Models\DadoPessoal;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\HomeController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Posmat\Notifications\AtivaConta;



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

		/*string usada para gerar o código de validação do e-mail. Deve ser grande por questões de segurança.*/

		$STRING_VALIDA_EMAIL = "EsN7Qh2G#U(i24g@LQ=^=NMX74CmuVYZmAPNW?nE3ss6hxtUnvLZBjbD.V[7Y,8LW6trtj%CZWKr^aREKgm]QYW@87xZW4]CEK4mT[yz*o&t6VvzT,E2BGx2j2BP7%Jo{EkRM2Z=Pa4qWu4GeT83)pA]9*rHYctr}L4ka[c6YiweZq=Q>m$7tfPBQoW8wgFm86k8[iDu?HBA[9kiRJeH)7QGnND6oFAbD2Vq(2acX+TAmQbMq3jPUVJ,JPaA]9.)";

		$this->validate($request,[
			'nome' => 'required|max:255',
			'email'  => 'required|unique:users|email|max:255',
			'confirmar-email'  => 'required|email|same:email|max:255',
			'password'  => 'required|min:6',
			'confirmar-password'  => 'required|same:password|min:6',

		]);

		$novo_usuario = new User();

		if (Session::has('locale')) {
			$novo_usuario->locale = Session::get('locale');
		}else{
			$novo_usuario->locale = "pt-br";
		}
		
        $novo_usuario->email = Purifier::clean(strtolower(trim($request->input('email'))));
        $novo_usuario->password = bcrypt(trim($request->input('password')));
        $novo_usuario->validation_code =  md5($STRING_VALIDA_EMAIL.$request->input('email').date("d-m-Y H:i:s:u"));

        $novo_usuario->save();
		
		$id_user = $novo_usuario->id_user;

		$cria_candidato = new DadoPessoal();
		$cria_candidato->id_user = $id_user;
		$cria_candidato->nome = Purifier::clean(trim($request->input('nome')));
		$cria_candidato->save();

		Notification::send(User::find($id_user), new AtivaConta($novo_usuario->validation_code));

		notify()->flash(trans('tela_registro.menu_registro_sucesso_parte_inicial').' '.$novo_usuario->email.' '.trans('tela_registro.menu_registro_sucesso_parte_final'),'info');

		return redirect()->route('home');

	}

	public function getLogin()
	{	
		return view('auth.login');
	}

	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required',
		]);

		
		$user = DB::table('users')->where('email', strtolower(trim($request->input('email'))))->value('ativo');

		if (!$user) {
			notify()->flash('Você não ativou sua conta ainda. Você deve clicar no link de ativação que foi enviado para seu e-mail.','info');
			return redirect()->back();
		}else{
			if (!Auth::attempt($request->only(['email', 'password']))) {
				notify()->flash('Usuário ou senha não conferem!', 'error',[
					'timer' => 3000,
				]);
				return redirect()->back();
			}
		}

		$user_type = DB::table('users')->where('email', $request->input('email'))->value('user_type');

		$home = new HomeController();
		if (Session::has('locale')) {
			$home->setaLocale(Session::get('locale'));
		}
		
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

		if ($user_type === 'candidato') {
			notify()->flash('Bem vindo!','success',[
				'timer' => 1500,
			]);
			return redirect()->intended('candidato');
		}

		if ($user_type === 'recomendante') {
			notify()->flash('Bem vindo!','success',[
				'timer' => 1500,
			]);
			return redirect()->intended('recomendante');
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