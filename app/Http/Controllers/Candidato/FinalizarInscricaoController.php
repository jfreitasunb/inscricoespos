<?php

namespace InscricoesPos\Http\Controllers\Candidato;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\AssociaEmailsRecomendante;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaMotivacao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\DadoPessoalCandidato;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\DadoAcademicoCandidato;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\DadoPessoalRecomendante;
use InscricoesPos\Models\ContatoRecomendante;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\Documento;
use InscricoesPos\Models\Paises;
use InscricoesPos\Models\Cidade;
use InscricoesPos\Notifications\NotificaRecomendante;
use InscricoesPos\Notifications\NotificaCandidato;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\RelatorioController;
use InscricoesPos\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use InscricoesPos\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
* Classe para manipulação do candidato.
*/
class FinalizarInscricaoController extends BaseController
{

	public function getFinalizarInscricao(){

		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;

		$locale_candidato = Session::get('locale');

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();
		$arquivos_editais = storage_path("/app/editais/");

		if ($autoriza_inscricao) {


			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_candidato,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			$dados_pessoais = new DadoPessoalCandidato();

			$dados_pessoais_candidato = $dados_pessoais->retorna_dados_pessoais($id_candidato);

			$nome_candidato = User::find($id_candidato)->nome;

			if (is_null($dados_pessoais_candidato)) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_dados_pessoais'),'warning');

				return redirect()->route('dados.pessoais');
			}

			$informou_dados_academicos = DadoAcademicoCandidato::find($id_candidato);


			if (is_null($informou_dados_academicos)) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_dados_academicos'),'warning');

				return redirect()->route('dados.academicos');
			}

			$informou_escolha = new EscolhaCandidato();

			$escolheu = $informou_escolha->retorna_escolha_candidato($id_candidato,$id_inscricao_pos);
			


			if (is_null($escolheu)) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_escolha'),'warning');

				return redirect()->route('dados.escolhas');
			}

			$recomendantes_candidato = new ContatoRecomendante();

			$informou_recomendantes = $recomendantes_candidato->retorna_recomendante_candidato($id_candidato,$id_inscricao_pos);


			if (count($informou_recomendantes) < 3) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_recomendante'),'warning');

				return redirect()->route('dados.escolhas');
			}

			$informou_motivacao = new CartaMotivacao();

			$fez_carta_motivacao = $informou_motivacao->retorna_carta_motivacao($id_candidato, $id_inscricao_pos);

			if (is_null($fez_carta_motivacao)) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_motivacao'),'warning');

				return redirect()->route('motivacao.documentos');
			}

			$documentos = new Documento();

			$enviou_historico = $documentos->retorna_historico($id_candidato, $id_inscricao_pos);

			$enviou_documentos = $documentos->retorna_documento($id_candidato, $id_inscricao_pos);

			if (is_null($enviou_historico) or is_null($enviou_documentos)) {
				
				notify()->flash(trans('tela_finalizar_inscricao.falta_documentos'),'warning');

				return redirect()->route('motivacao.documentos');
			}
			
			$novo_relatorio = new RelatorioController;

			$ficha_inscricao = $novo_relatorio->geraFichaInscricao($id_candidato, $id_inscricao_pos, $locale_candidato);


			return view('templates.partials.candidato.finalizar_inscricao',compact('ficha_inscricao','nome_candidato'));

		}else{
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}	
	}

	public function postFinalizarInscricao(Request $request){

		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;

		$locale_fixo = 'en';

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if ($autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_candidato,$id_inscricao_pos);

			if ($status_inscricao) {
				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}

			$dados_pessoais_candidato = User::find($id_candidato);

			$escolha_candidato = new EscolhaCandidato();

			$programa_pretendido = $escolha_candidato->retorna_escolha_candidato($id_candidato,$id_inscricao_pos)->programa_pretendido;
			$programa_pos = new ProgramaPos();

			$nome_programa_pos_candidato = $programa_pos->pega_programa_pos_mat($programa_pretendido, $locale_fixo);

			$dados_email_candidato['nome_candidato'] = $dados_pessoais_candidato->nome;
			$dados_email_candidato['programa'] = $nome_programa_pos_candidato;

			$recomendantes_candidato = new ContatoRecomendante();

			$informou_recomendantes = $recomendantes_candidato->retorna_recomendante_candidato($id_candidato,$id_inscricao_pos);

			foreach ($informou_recomendantes as $recomendante) {
				
				if (!$recomendante->email_enviado) {

					$dado_pessoal_recomendante = User::find($recomendante->id_recomendante);


					$prazo_envio = Carbon::createFromFormat('Y-m-d', $edital_ativo->retorna_inscricao_ativa()->prazo_carta);

					$dados_email['nome_professor'] = $dado_pessoal_recomendante->nome;
        			$dados_email['nome_candidato'] = $dados_pessoais_candidato->nome;
			        $dados_email['programa'] = $nome_programa_pos_candidato;
        			$dados_email['email_recomendante'] = $dado_pessoal_recomendante->email;
        			$dados_email['prazo_envio'] = $prazo_envio->format('d/m/Y');

					Notification::send(User::find($recomendante->id_recomendante), new NotificaRecomendante($dados_email));

					DB::table('contatos_recomendantes')->where('id', $recomendante->id)->where('id_candidato', $recomendante->id_candidato)->where('id_inscricao_pos', $recomendante->id_inscricao_pos)->update(['email_enviado' => TRUE, 'updated_at' => date('Y-m-d H:i:s')]);

				}
			}
			
			$finalizar_inscricao = new FinalizaInscricao();

			$id_finalizada_anteriormente = $finalizar_inscricao->select('id')->where('id_candidato',$id_candidato)->where('id_inscricao_pos',$id_inscricao_pos)->pluck('id');

			if (count($id_finalizada_anteriormente)>0){

				DB::table('finaliza_inscricao')->where('id', $id_finalizada_anteriormente[0])->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update(['finalizada' => True, 'updated_at' => date('Y-m-d H:i:s')]);
			}else{
				
				$finalizar_inscricao->id_candidato = $id_candidato;
				$finalizar_inscricao->id_inscricao_pos = $id_inscricao_pos;
				$finalizar_inscricao->finalizada = true;
				$finalizar_inscricao->save();
			}

			$dados_email_candidato['ficha_inscricao'] = $request->ficha_inscricao;
			
			Notification::send(User::find($id_candidato), new NotificaCandidato($dados_email_candidato));

			notify()->flash(trans('mensagens_gerais.envio_final'),'success');

			return redirect()->route('home');

		}
	}
}