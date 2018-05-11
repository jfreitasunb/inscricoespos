<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use Posmat\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, RelatorioController, FinalizaInscricao, ContatoRecomendante, DadoRecomendante, DadoPessoal, EscolhaCandidato, CartaRecomendacao, AssociaEmailsRecomendante};
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CoordenadorController;
use Posmat\Http\Controllers\DataTable\UserController;
use Posmat\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class PesquisaContaController extends AdminController
{

	public function getPesquisaConta()
	{	
		$modo_pesquisa = true;

		$tipo_pesquisa = $this->pesquisa;

		return view('templates.partials.admin.ativa_conta')->with(compact('modo_pesquisa', 'tipo_pesquisa'));
	}

	

	public function postPesquisaConta(Request $request)
	{
		
		$tipo_pesquisa = $this->pesquisa;

		$this->validate($request, [
			'campo_pesquisa' => 'required',
		]);

		$pesquisar_por = $request->tipo_pesquisa;

		$usuario = new User();

		switch ($pesquisar_por) {
			case 'nome':
				$termo_pesquisado = strtr($request->campo_pesquisa, $this->unwanted_array);

				$dado_pessoal = new DadoPessoal;

				$users = $dado_pessoal->retorna_user_por_nome($termo_pesquisado);
				
				break;
			
			default:
				$termo_pesquisado = strtolower(trim($request->campo_pesquisa));
				
				$temporario = $usuario->retorna_usuario_por_email($termo_pesquisado);

				$users[$temporario->id_user]['id_user'] = $temporario->id_user;

				$users[$temporario->id_user]['nome'] = $temporario->nome;;

				$users[$temporario->id_user]['email'] = $temporario->email;

				$users[$temporario->id_user]['locale'] = $temporario->locale;

				$users[$temporario->id_user]['user_type'] = $temporario->user_type;

				$users[$temporario->id_user]['ativo'] = $temporario->ativo;
				break;
		}

		if (!is_null($users)) {
			
			$modo_pesquisa = false;

			return view('templates.partials.admin.ativa_conta')->with(compact('modo_pesquisa', 'users', 'tipo_pesquisa', 'pesquisar_por', 'termo_pesquisado'));
		}else{
			notify()->flash('Não existe nenhuma conta registrada com o e-mail: '.$termo_pesquisado.'!','error');
			return redirect()->route('pesquisa.usuario');
		}
	}
}