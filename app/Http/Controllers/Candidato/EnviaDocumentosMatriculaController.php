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
use InscricoesPos\Rules\NumeroUploads;

/**
* Classe para manipulação do candidato.
*/
class EnviaDocumentosMatriculaController extends BaseController
{

	public function getEnviaDocumentosMatricula(){

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$locale_candidato = Session::get('locale');

		$candidato_selecionado = new CandidatosSelecionados();

		$id_inscricao_pos_candidato = $candidato_selecionado->encontra_id_tabela($id_user);

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;

		$id_programa_foi_selecionado = (int)$candidato_selecionado->retorna_ja_foi_selecionado($id_candidato);

        $diferenca = $id_inscricao_pos - $id_programa_foi_selecionado;

        if (($diferenca > 0) and ($diferenca < $id_inscricao_pos) and ($diferenca < 2)) {
            $id_inscricao_pos = $id_programa_foi_selecionado;
        }
		
		if ($id_inscricao_pos_candidato == $id_inscricao_pos ) {
			
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
		}else{

			if ($id_inscricao_pos_candidato != 0) {
                    
                $id_inscricao_pos = $id_inscricao_pos_candidato;
            }
			
			$edital = $edital_ativo->retorna_inscricao_ativa($id_inscricao_pos_candidato)->edital;
			
			$autoriza_inscricao = $edital_ativo->autoriza_inscricao($id_inscricao_pos);

			if (!$autoriza_inscricao) {
				
				$finaliza_inscricao = new FinalizaInscricao();

				$configura_inicio = new ConfiguraEnvioDocumentosMatricula();

				$libera_tela = $configura_inicio->libera_tela_documento_matricula($id_inscricao_pos);

				$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user, $id_inscricao_pos);

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
	}

	public function postEnviaDocumentosMatricula(Request $request)
	{	
		
		$input_data = $request->all();
		
		$validator = Validator::make(
        	$input_data, 
		        [
		            'arquivos_matricula.*' => 'required|mimes:pdf|max:20000',
		            'arquivos_matricula' => new ArrayUnico,
		            'arquivos_matricula' => new NumeroUploads,
		        ],[
		            'arquivos_matricula.*.required' => trans('documentos_matricula.obrigatorio'),
		            'arquivos_matricula.*.mimes' => trans('documentos_matricula.somente_pdf'),
		            'arquivos_matricula.*.max' => trans('documentos_matricula.tamanho_maximo'),
		        ]
    		);
		
		if ($validator->fails()) {
        	
        	notify()->flash($validator->messages()->first(),'error');
				
			return redirect()->route('envia.documentos.matricula');
    	}

    	foreach ($input_data['arquivos_matricula'] as $key => $value) {
    		$array_tipos_documentos[] = $key;
    	}

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

			if ($id_inscricao_pos != $edital_ativo->retorna_inscricao_ativa($id_inscricao_pos)->id_inscricao_pos) {
			
				return redirect()->back();
			}
			
			if ($id_candidato != $id_user) {
			
				return redirect()->back();
			}

			$edital = $edital_ativo->retorna_inscricao_ativa($id_inscricao_pos)->edital;
			
			$autoriza_inscricao = $edital_ativo->autoriza_inscricao($id_inscricao_pos);

			if (!$autoriza_inscricao) {
				
				$finaliza_inscricao = new FinalizaInscricao();

				$status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user, $id_inscricao_pos);

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

							$arquivo_matricula->arquivo_final_valido = FALSE;
							
							$arquivo_matricula->save();

						}else{

							$nome_arquivo = explode("/", $arquivo_ja_enviado);

							$request->arquivos_matricula[$key]->storeAs('arquivos_internos', $nome_arquivo[1]);

							$arquivo_matricula->atualiza_arquivos_enviados($id_candidato, $id_inscricao_pos, $id_programa_pretendido, $key, Storage::exists($arquivo_ja_enviado));
						}
					}
					notify()->flash(trans('mensagens_gerais.documentos_matricula_sucesso'),'success');
				
					return redirect()->route('documento.final.matricula');
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
