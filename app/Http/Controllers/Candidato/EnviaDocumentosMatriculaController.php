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
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\ConfiguraInicioPrograma;
use InscricoesPos\Models\ConfiguraEnvioDocumentosMatricula;
use InscricoesPos\Models\DocumentoMatricula;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\HomologaInscricoes;
use InscricoesPos\Models\CandidatosSelecionados;
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
use InscricoesPos\Rules\ArrayUnico;
/**
* Classe para manipulação do candidato.
*/
class EnviaDocumentosMatriculaController extends BaseController
{

	public function getEnviaDocumentosMatricula(){

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$locale_candidato = Session::get('locale');

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if (!$autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaInscricao();

			$configura_inicio = new ConfiguraEnvioDocumentosMatricula();

			$libera_tela = $configura_inicio->libera_tela_documento_matricula($id_inscricao_pos);

			$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

			if (!$status_inscricao) {

				return redirect()->route('home');
			}

			$homologa = new HomologaInscricoes();

			$candidato_homologado = $homologa->retorna_se_foi_homologado($id_user, $id_inscricao_pos);

			if (!$candidato_homologado) {
				
				return redirect()->route('home');
			}

			$selecionado = new CandidatosSelecionados();

			$status_selecao = $selecionado->retorna_status_selecionado($id_inscricao_pos, $id_user);
			
			if (!$status_selecao->selecionado) {

				return redirect()->route('home');
			}

			if (!$status_selecao->confirmou_presenca) {

				return redirect()->route('home');
			}
			

			if (!$libera_tela) {
				
				return redirect()->route('home');
			}

			$nome = User::find($id_user)->nome;

			$dados_para_template['id_candidato'] = $id_user;

			$dados_para_template['id_inscricao_pos'] = $id_inscricao_pos;

			$dados_para_template['nome'] = $nome;
			
			$dados_para_template['id_programa_pretendido'] = $status_selecao->programa_pretendido;

			return view('templates.partials.candidato.envia_documentos_matricula', compact('dados_para_template'));

		}else{
			
			return redirect()->back();
		}
	}

	public function postEnviaDocumentosMatricula(Request $request)
	{	
		// $request->validate([
  //           'arquivos_matricula' =>  ['required', new ArrayUnico],
		// ]);

		$array_tipos_documentos = ['fc', 'dg', 'hg', 'ci', 'cp', 'te', 'ce'];

		$id_candidato = (int)$request->id_candidato;

		$id_inscricao_pos = (int)$request->id_inscricao_pos;

		$id_programa_pretendido = (int)$request->id_programa_pretendido;
		
		$configura_inicio = new ConfiguraEnvioDocumentosMatricula();

		$inicio_prazo = $configura_inicio->retorna_inicio_prazo_envio_documentos($id_inscricao_pos);

		$fim_prazo = $configura_inicio->retorna_fim_prazo_envio_documentos($id_inscricao_pos);

		$libera_tela = $configura_inicio->libera_tela_documento_matricula($id_inscricao_pos);

		if ($libera_tela) {

			$user = $this->SetUser();
			
			$id_user = $user->id_user;

			$locale_candidato = Session::get('locale');

			$edital_ativo = new ConfiguraInscricaoPos();

			if ($id_inscricao_pos != $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos) {
			
				return redirect()->back();
			}
			
			if ($id_candidato != $id_user) {
			
				return redirect()->back();
			}

			$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
			
			$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

			if (!$autoriza_inscricao) {
				
				$finaliza_inscricao = new FinalizaInscricao();

				$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

				if (!$status_inscricao) {

					return redirect()->back();
				}

				$homologa = new HomologaInscricoes();

				$candidato_homologado = $homologa->retorna_se_foi_homologado($id_user, $id_inscricao_pos);

				if (!$candidato_homologado) {

					return redirect()->back();
				}

				$selecionado = new CandidatosSelecionados();

				$status_selecao = $selecionado->retorna_status_selecionado($id_inscricao_pos, $id_user);

				if (!$status_selecao->selecionado) {

					return redirect()->back();
				}

				$data_hoje = (new Carbon())->format('Y-m-d');
				
				if (($data_hoje >= $inicio_prazo) && ($data_hoje <= $fim_prazo)) {
					
					foreach ($array_tipos_documentos as $key) {
		
						$arquivo_matricula = new DocumentoMatricula();
						
						$arquivo_ja_enviado = $arquivo_matricula->retorna_se_arquivo_foi_enviado($id_candidato, $id_inscricao_pos, $id_programa_pretendido, $key);

						if (is_null($arquivo_ja_enviado)) {

							$arquivo = $request->arquivos_matricula[$key]->store('arquivos_internos');

							$arquivo_matricula->id_candidato = $id_candidato;

							$arquivo_matricula->id_inscricao_pos = $id_inscricao_pos;

							$arquivo_matricula->id_programa_pretendido = $id_programa_pretendido;
							
							$arquivo_matricula->tipo_arquivo = $key;

							$arquivo_matricula->nome_arquivo = $arquivo;
							
							$arquivo_matricula->arquivo_recebido = Storage::exists($arquivo);

							$arquivo_matricula->arquivo_final = FALSE;
							
							$arquivo_matricula->save();
						}else{

							$nome_arquivo = explode("/", $arquivo_ja_enviado);

							$request->arquivos_matricula[$key]->storeAs('arquivos_internos', $nome_arquivo[1]);

							//atualizar banco
						}
						
					}
				}else{
					
					notify()->flash(trans('mensagens_gerais.documentos_matricula_erro_fora_prazo'),'error');
				
					return redirect()->route('home');
				}
			}else{
				
				return redirect()->back();
			}
		}else{
			
			return redirect()->route('home');
		}
	}
}