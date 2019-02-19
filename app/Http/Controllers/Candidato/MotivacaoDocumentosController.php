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

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_candidato,$id_inscricao_pos);

			if ($status_inscricao) {

				notify()->flash(trans('mensagens_gerais.inscricao_finalizada'),'warning');

				return redirect()->back();
			}else{

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
		$this->validate($request, [
			'motivacao' => 'required',
			'documentos_pessoais' => 'required|max:50000|mimes:pdf',
			'historico' => 'required|max:50000|mimes:pdf',
			'comprovante_ingles' => 'required|max:50000|mimes:pdf',
			'comprovante_proficiencia' => 'required|max:50000|mimes:pdf',
			'concorda_termos' => 'required',
		]);

			$user = $this->SetUser();
			
			$id_candidato = $user->id_user;

			$edital_ativo = new ConfiguraInscricaoPos();

			$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
			
			$doc_pessoais = $request->documentos_pessoais->store('uploads');
			$arquivo = new Documento();
			$arquivo->id_candidato = $id_candidato;
			$arquivo->nome_arquivo = $doc_pessoais;
			$arquivo->tipo_arquivo = "Documentos";
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
			$arquivo->save();

			$hist = $request->historico->store('uploads');

			$arquivo = new Documento();
			$arquivo->id_candidato = $id_candidato;
			$arquivo->nome_arquivo = $hist;
			$arquivo->tipo_arquivo = "Histórico";
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
			$arquivo->save();

			$comprovante_en = $request->comprovante_ingles->store('uploads');

			$arquivo = new Documento();
			$arquivo->id_candidato = $id_candidato;
			$arquivo->nome_arquivo = $comprovante_en;
			$arquivo->tipo_arquivo = "Comprovante Inglês";
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
			$arquivo->save();

			$comprovante_prof = $request->comprovante_proficiencia->store('uploads');

			$arquivo = new Documento();
			$arquivo->id_candidato = $id_candidato;
			$arquivo->nome_arquivo = $comprovante_proficiencia;
			$arquivo->tipo_arquivo = "Comprovante Proficiencia Inglês";
			$arquivo->id_inscricao_pos = $id_inscricao_pos;
			$arquivo->save();

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