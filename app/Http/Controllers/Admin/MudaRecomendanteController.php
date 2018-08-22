<?php

namespace InscricoesPos\Http\Controllers\Admin;

use Auth;
use DB;
use Mail;
use Session;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\{User, ConfiguraInscricaoPos, AreaPosMat, ProgramaPos, RelatorioController, FinalizaInscricao, ContatoRecomendante, DadoPessoalRecomendante, DadoPessoalCandidato, EscolhaCandidato, CartaRecomendacao, AssociaEmailsRecomendante};
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CoordenadorController;
use InscricoesPos\Http\Controllers\DataTable\UserController;
use InscricoesPos\Notifications\NotificaRecomendante;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class MudaRecomendanteController extends AdminController
{

	public function getPesquisarRecomendantes(){

		$modo_pesquisa = true;
		
		return view('templates.partials.admin.altera_recomendantes_candidato')->with(compact('modo_pesquisa'));
	}

	public function getPesquisaCandidato($email_candidato)
	{
	
		$user = new User;

		return $user->retorna_user_por_email($email_candidato)->id_user;
	}


	public function postPesquisarRecomendantes(Request $request)
	{

		$this->validate($request, [
			'email_candidato' => 'required|email',
		]);

		$email_candidato = strtolower(trim($request->email_candidato));

		$id_candidato = $this->getPesquisaCandidato($email_candidato);

		$dados_pessoais = User::find($id_candidato);

		$edital = new ConfiguraInscricaoPos;

		$edital_vigente = $edital->retorna_edital_vigente();

		$id_inscricao_pos = $edital_vigente->id_inscricao_pos;

		$escolha = new EscolhaCandidato;

		$escolha_candidato = $escolha->retorna_escolha_candidato($id_candidato, $id_inscricao_pos);

		$nome_programa_pos = new ProgramaPos();

		$recomendantes = new ContatoRecomendante;

		$indicacoes_candidato = $recomendantes->retorna_recomendante_candidato($id_candidato, $id_inscricao_pos);

		$array_recomendantes = [];

		$candidato = [];

		$candidato['id_inscricao_pos'] = $id_inscricao_pos;

		$candidato['id_candidato'] = $id_candidato;

		$candidato['nome'] = $dados_pessoais->nome;

		$candidato['programa'] = $nome_programa_pos->pega_programa_pos_mat($escolha_candidato->programa_pretendido, $this->locale_default);

		$candidato['edital'] = $edital_vigente->edital;

		foreach ($indicacoes_candidato as $indicacao) {
			
			$dados_pessoais_recomendante = User::find($indicacao->id_recomendante);

			$array_recomendantes[$indicacao->id_recomendante]['id'] = $indicacao->id;

			$array_recomendantes[$indicacao->id_recomendante]['nome_recomendante'] = $dados_pessoais_recomendante->nome;

			$array_recomendantes[$indicacao->id_recomendante]['email_recomendante'] = $dados_pessoais_recomendante->email;
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
			'id_candidato' => 'required',
			'id_inscricao_pos' => 'required',
			'id_recomendante' => 'required',
			'id_recomendante' => 'required',
			'nome_recomendante' => 'required',
			'email_recomendante' => 'required|email',
		]);


		$id = (int)$request->id;
		$id_candidato = (int)$request->id_candidato;
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
            
            $dados_iniciais_recomendante = new DadoPessoalRecomendante();

            $grava_dados_inicias = $dados_iniciais_recomendante->grava_dados_iniciais_recomendante($id_novo_recomendante, $nome_recomendante);

		}else{

			if ($acha_recomendante->user_type === 'recomendante') {
				$id_novo_recomendante = $acha_recomendante->id_user;
			}else{

				notify()->flash('O e-mail: '.$email_recomendante.' pertence a um candidato!','error');
				return redirect()->back();
			}	
		}

		$mudou_recomendante = DB::table('cartas_recomendacoes')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('id_recomendante', $id_recomendante)->where('completada', false)->update(['id_recomendante' => $id_novo_recomendante, 'updated_at' => date('Y-m-d H:i:s') ]);

		if (!$mudou_recomendante) {
			
			notify()->flash('O recomendante original já enviou a carta. Não é possível trocar!','error');
			return redirect()->back();
			
		}

		DB::table('contatos_recomendantes')->where('id', $id)->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('id_recomendante', $id_recomendante)->update(['id_recomendante' => $id_novo_recomendante, 'updated_at' => date('Y-m-d H:i:s') ]);

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