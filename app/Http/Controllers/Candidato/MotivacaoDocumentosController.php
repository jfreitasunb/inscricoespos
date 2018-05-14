<?php

namespace Posmat\Http\Controllers\Candidato;

use Auth;
use DB;
use Mail;
use Session;
use Validator;
use Purifier;
use Notification;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\AssociaEmailsRecomendante;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\CartaMotivacao;
use Posmat\Models\ProgramaPos;
use Posmat\Models\DadoPessoal;
use Posmat\Models\Formacao;
use Posmat\Models\Estado;
use Posmat\Models\DadoAcademico;
use Posmat\Models\EscolhaCandidato;
use Posmat\Models\DadoRecomendante;
use Posmat\Models\ContatoRecomendante;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\FinalizaInscricao;
use Posmat\Models\Documento;
use Posmat\Models\Paises;
use Posmat\Models\Cidade;
use Posmat\Notifications\NotificaRecomendante;
use Posmat\Notifications\NotificaCandidato;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Posmat\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
* Classe para manipulação do candidato.
*/
class MotivacaoDocumentosController extends BaseController
{

	public function getMotivacaoDocumentos()
	{
		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		$arquivos_editais = "storage/editais/";
	
		if ($autoriza_inscricao) {
		
			$finaliza_inscricao = new FinalizaInscricao();

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}else{

				$motivacao = new CartaMotivacao();

				$fez_carta_motivacao = $motivacao->retorna_carta_motivacao($id_user,$id_inscricao_pos);

				if (is_null($fez_carta_motivacao)) {
					$dados['motivacao'] = '';

					return view('templates.partials.candidato.motivacao_documentos',compact('arquivos_editais','edital', 'dados'));
				}else{

					$dados['motivacao'] = $fez_carta_motivacao->motivacao;

					return view('templates.partials.candidato.motivacao_documentos',compact('arquivos_editais','edital','dados'));
				}
				
			}
		}else{
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}
	}

	public function postMotivacaoDocumentos(Request $request)
	{
		$this->validate($request, [
			'motivacao' => 'required',
			'documentos_pessoais' => 'required|max:20000',
			'historico' => 'required|max:20000',
			'concorda_termos' => 'required',
		]);

			$user = $this->SetUser();
			
			$id_user = $user->id_user;

			$edital_ativo = new ConfiguraInscricaoPos();

			$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
			
			$doc_pessoais = $request->documentos_pessoais->store('uploads');
			$arquivo = new Documento();
			$arquivo->id_user = $id_user;
			$arquivo->nome_arquivo = $doc_pessoais;
			$arquivo->tipo_arquivo = "Documentos";
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
			$arquivo->save();

			$hist = $request->historico->store('uploads');
			$arquivo = new Documento();
			$arquivo->id_user = $id_user;
			$arquivo->nome_arquivo = $hist;
			$arquivo->tipo_arquivo = "Histórico";
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
			$arquivo->save();

			$motivacao = new CartaMotivacao();

			$carta_motivacao = $motivacao->retorna_carta_motivacao($id_user, $id_inscricao_pos);

			if (count($carta_motivacao)==0) {
				$nova_motivacao = new CartaMotivacao();
				$nova_motivacao->id_user = $id_user;
				$nova_motivacao->motivacao = Purifier::clean($request->input('motivacao'));
				$nova_motivacao->concorda_termos = (bool)$request->input('concorda_termos');
				$nova_motivacao->id_inscricao_pos = $id_inscricao_pos;
				$nova_motivacao->save();
			}else{
				$dados_motivacao['motivacao'] = Purifier::clean($request->input('motivacao'));
				$dados_motivacao['updated_at'] = date('Y-m-d H:i:s');
				
				DB::table('carta_motivacoes')->where('id_user', $id_user)->where('id_inscricao_pos', $id_inscricao_pos)->update($dados_motivacao);
			}

			notify()->flash(trans('mensagens_gerais.mensagem_sucesso'),'success');

			return redirect()->route('finalizar.inscricao');		
	}
}