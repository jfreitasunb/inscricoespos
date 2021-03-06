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
use InscricoesPos\Models\DadoPessoal;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\Estado;
use InscricoesPos\Models\DadoAcademico;
use InscricoesPos\Models\EscolhaCandidato;
use InscricoesPos\Models\DadoRecomendante;
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
use InscricoesPos\Http\Controllers\APIController;
use Illuminate\Foundation\Auth\RegistersUsers;
use InscricoesPos\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

/**
* Classe para manipulação do candidato.
*/
class MotivacaoDocumentosController extends BaseController
{

	public function getMotivacaoDocumentos()
	{
		$anexos = array('1' => 'VI', '2' => 'V', '3' => 'VII', '4' => 'IV');
		
		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;

		$locale_candidato = User::find($id_candidato)->locale;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		$arquivos_editais = "storage/editais/";

		$edital_pdf = 'Edital_MAT_'.$edital.'_ptbr';

		if ($locale_candidato == 'en' && file_exists(storage_path("app/public/editais/").'Edital_MAT_'.$edital.'_en.pdf') ) {
			$edital_pdf = 'Edital_MAT_'.$edital.'_en';
		}
		
		if ($locale_candidato == 'es' && file_exists(storage_path("app/public/editais/").'Edital_MAT_'.$edital.'_es.pdf') ) {
			$edital_pdf = 'Edital_MAT_'.$edital.'_es';
		}

		if ($autoriza_inscricao) {
		
			$finaliza_inscricao = new FinalizaInscricao();

			$finaliza_inscricao->inicializa_tabela_finalizacao($id_candidato, $id_inscricao_pos);

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_candidato,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}else{

				$escolha = new EscolhaCandidato();

				$candidato_ja_escolheu = $escolha->retorna_escolha_candidato($id_candidato, $id_inscricao_pos);
				if (!is_null($candidato_ja_escolheu)) {
					$dados['tipo_cotista'] = $candidato_ja_escolheu->id_tipo_cotista;

					if ($candidato_ja_escolheu->id_tipo_cotista != 5) {
						$dados['numero_anexo'] = $anexos[$candidato_ja_escolheu->id_tipo_cotista];
					}
				}
				
				$motivacao = new CartaMotivacao();

				$fez_carta_motivacao = $motivacao->retorna_carta_motivacao($id_candidato,$id_inscricao_pos);

				if (is_null($fez_carta_motivacao)) {
					$dados['motivacao'] = '';

					return view('templates.partials.candidato.motivacao_documentos',compact('arquivos_editais', 'edital', 'edital_pdf', 'dados'));
				}else{

					$dados['motivacao'] = $fez_carta_motivacao->motivacao;

					return view('templates.partials.candidato.motivacao_documentos',compact('arquivos_editais', 'edital', 'edital_pdf', 'dados'));
				}
				
			}
		}else{
			notify()->flash(trans('mensagens_gerais.inscricao_inativa'),'warning');
			
			return redirect()->route('home');
		}
	}

	public function postMotivacaoDocumentos(Request $request)
	{	
		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;

		$escolha = new EscolhaCandidato();

		$candidato_ja_escolheu = $escolha->retorna_escolha_candidato($id_candidato, $id_inscricao_pos);
		
		if (!is_null($candidato_ja_escolheu)) {
			if ($candidato_ja_escolheu->id_tipo_cotista != 5) {
				$this->validate($request, [
					'motivacao' => 'required',
					'comprovacao_cota_social' => 'required|max:50000|mimes:pdf',
					'documentos_pessoais' => 'required|max:50000|mimes:pdf',
					'historico' => 'required|max:50000|mimes:pdf',
					'projeto' => 'required|max:50000|mimes:pdf',
					'comprovante_proficiencia' => 'max:50000|mimes:pdf',
					'concorda_termos' => 'required',
				]);
			}else{
				$this->validate($request, [
					'motivacao' => 'required',
					'documentos_pessoais' => 'required|max:50000|mimes:pdf',
					'historico' => 'required|max:50000|mimes:pdf',
					'projeto' => 'required|max:50000|mimes:pdf',
					'comprovante_proficiencia' => 'max:50000|mimes:pdf',
					'concorda_termos' => 'required',
				]);
			}
		}else{
			$this->validate($request, [
				'motivacao' => 'required',
				'documentos_pessoais' => 'required|max:50000|mimes:pdf',
				'historico' => 'required|max:50000|mimes:pdf',
				'projeto' => 'required|max:50000|mimes:pdf',
				'comprovante_proficiencia' => 'max:50000|mimes:pdf',
				'concorda_termos' => 'required',
			]);
		}

		$user = $this->SetUser();
		
		$id_candidato = $user->id_user;

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		
		$finaliza_inscricao = new FinalizaInscricao();

		$finaliza_inscricao->inicializa_tabela_finalizacao($id_candidato, $id_inscricao_pos);

		if (!is_null($candidato_ja_escolheu)) {
			if ($candidato_ja_escolheu->id_tipo_cotista != 5) {
			
				$arquivo = new Documento();
					
				$comprovante_cota_ja_enviados = $arquivo->retorna_arquivo_edital_atual($id_candidato, $id_inscricao_pos, 'Cotista');

				if (is_null($comprovante_cota_ja_enviados)) {

					$doc_cotista = $request->comprovacao_cota_social->store('uploads');

					$arquivo->id_candidato = $id_candidato;
				
					$arquivo->nome_arquivo = $doc_cotista;
				
					$arquivo->tipo_arquivo = "Cotista";
				
					$arquivo->id_inscricao_pos = $id_inscricao_pos;
				
					$arquivo->save();
				}else{
					
					$nome_arquivo = explode("/", $comprovante_cota_ja_enviados->nome_arquivo);

					$request->comprovacao_cota_social->storeAs('uploads', $nome_arquivo[1]);

					$arquivo->atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, 'Cotista');
				}
			}
		}
		
		$arquivo = new Documento();
				
		$doc_pessoais_ja_enviados = $arquivo->retorna_arquivo_edital_atual($id_candidato, $id_inscricao_pos, 'Documentos');

		if (is_null($doc_pessoais_ja_enviados)) {

			$doc_pessoais = $request->documentos_pessoais->store('uploads');

			$arquivo->id_candidato = $id_candidato;
		
			$arquivo->nome_arquivo = $doc_pessoais;
		
			$arquivo->tipo_arquivo = "Documentos";
		
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
		
			$arquivo->save();
		}else{
			
			$nome_arquivo = explode("/", $doc_pessoais_ja_enviados->nome_arquivo);

			$request->documentos_pessoais->storeAs('uploads', $nome_arquivo[1]);

			$arquivo->atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, 'Documentos');
		}
		
		$historico = new Documento();
				
		$historico_ja_enviado = $historico->retorna_arquivo_edital_atual($id_candidato, $id_inscricao_pos, 'Histórico');

		if (is_null($historico_ja_enviado)) {
			
			$hist = $request->historico->store('uploads');

			$historico->id_candidato = $id_candidato;
		
			$historico->nome_arquivo = $hist;
		
			$historico->tipo_arquivo = "Histórico";
		
			$historico->id_inscricao_pos = $id_inscricao_pos;
		
			$historico->save();

		}else{
			
			$nome_historico = explode("/", $historico_ja_enviado->nome_arquivo);

			$request->historico->storeAs('uploads', $nome_historico[1]);

			$historico->atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, 'Histórico');
		}

		$projeto = new Documento();
				
		$projeto_ja_enviado = $projeto->retorna_arquivo_edital_atual($id_candidato, $id_inscricao_pos, 'Prova de Títulos');

		if (is_null($projeto_ja_enviado)) {
			
			$proj = $request->projeto->store('uploads');

			$projeto->id_candidato = $id_candidato;
		
			$projeto->nome_arquivo = $proj;
		
			$projeto->tipo_arquivo = "Prova de Títulos";
		
			$projeto->id_inscricao_pos = $id_inscricao_pos;
		
			$projeto->save();

		}else{
			
			$nome_projeto = explode("/", $projeto_ja_enviado->nome_arquivo);

			$request->projeto->storeAs('uploads', $nome_projeto[1]);

			$projeto->atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, 'Prova de Títulos');
		}


		if (!is_null($request->comprovante_proficiencia)) {
			
			$comprovante = new Documento();
				
			$comprovante_ja_enviado = $comprovante->retorna_arquivo_edital_atual($id_candidato, $id_inscricao_pos, 'Comprovante Proficiência Inglês');

			if (is_null($comprovante_ja_enviado)) {
				
				$comprove = $request->comprovante_proficiencia->store('uploads');

				$comprovante->id_candidato = $id_candidato;
			
				$comprovante->nome_arquivo = $comprove;
			
				$comprovante->tipo_arquivo = "Comprovante Proficiência Inglês";
			
				$comprovante->id_inscricao_pos = $id_inscricao_pos;
			
				$comprovante->save();

			}else{
				
				$nome_comprovante = explode("/", $comprovante_ja_enviado->nome_arquivo);
				
				$request->comprovante_proficiencia->storeAs('uploads', $nome_comprovante[1]);

				$comprovante->atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, 'Comprovante Proficiência Inglês');
			}
		}

		$motivacao = new CartaMotivacao();

		$carta_motivacao = $motivacao->retorna_carta_motivacao($id_candidato, $id_inscricao_pos);


		if (is_null($carta_motivacao)) {
			
			$nova_motivacao = new CartaMotivacao();
			
			$nova_motivacao->id_candidato = $id_candidato;
			
			$nova_motivacao->motivacao = Purifier::clean($request->input('motivacao'));
			
			$nova_motivacao->concorda_termos = (bool)$request->input('concorda_termos');
			
			$nova_motivacao->id_inscricao_pos = $id_inscricao_pos;
			
			$nova_motivacao->save();

		}else{
			
			$dados_motivacao['motivacao'] = Purifier::clean($request->input('motivacao'));
			
			$dados_motivacao['updated_at'] = date('Y-m-d H:i:s');
			
			DB::table('carta_motivacoes')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->update($dados_motivacao);
		}

		notify()->flash(trans('mensagens_gerais.mensagem_sucesso'),'success');

		return redirect()->route('finalizar.inscricao');		
	}
}
