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
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\HomologaInscricoes;
use InscricoesPos\Models\CandidatosSelecionados;
use InscricoesPos\Models\DocumentoMatricula;
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
class ConfirmaPresencaController extends BaseController
{

	public function getConfirmaPresenca(){

		$user = $this->SetUser();
		
		$id_user = $user->id_user;

		$locale_candidato = Session::get('locale');

		$edital_ativo = new ConfiguraInscricaoPos();

		$id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
		
		$edital = $edital_ativo->retorna_inscricao_ativa()->edital;
		
		$autoriza_inscricao = $edital_ativo->autoriza_inscricao();

		if (!$autoriza_inscricao) {
			
			$finaliza_inscricao = new FinalizaInscricao();

			$configura_inicio = new ConfiguraInicioPrograma();

			$libera_tela = $configura_inicio->libera_tela_confirmacao($id_inscricao_pos);

			$array_months = [];
			
			$array_months[1]  = trans('meses.mes_1');
			
			$array_months[2]  = trans('meses.mes_2');
			
			$array_months[3]  = trans('meses.mes_3');
			
			$array_months[4]  = trans('meses.mes_4');
			
			$array_months[5]  = trans('meses.mes_5');
			
			$array_months[6]  = trans('meses.mes_6');
			
			$array_months[7]  = trans('meses.mes_7');
			
			$array_months[8]  = trans('meses.mes_8');
			
			$array_months[9]  = trans('meses.mes_9');
			
			$array_months[10] = trans('meses.mes_10');
			
			$array_months[11] = trans('meses.mes_11');
			
			$array_months[12] = trans('meses.mes_12');

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

			if ($status_selecao->confirmou_presenca) {

				notify()->flash(trans('mensagens_gerais.confirmou_presenca'),'success');
			
				return redirect()->route('home');
			}
			
			$confirmar_mes = $configura_inicio->retorna_se_precisam_confirmar_mes($id_inscricao_pos, $status_selecao->programa_pretendido);
			
			$meses_inicio = [];
			
			$data_hoje = (new Carbon())->format('Y-m-d');

			if ($confirmar_mes) {

				$retorna_meses_confirmacao = $configura_inicio->retorna_meses_para_inicio($id_inscricao_pos);

				foreach ($retorna_meses_confirmacao as $mes_confirmacao) {
										
					$prazo = Carbon::createFromFormat('Y-m-d', $mes_confirmacao->prazo_confirmacao);

					if ($data_hoje <= $prazo) {
					
						if ($mes_confirmacao->programa_para_confirmar == $status_selecao->programa_pretendido) {
					
							$meses_inicio[$mes_confirmacao->id_inicio_programa] = $array_months[$mes_confirmacao->mes_inicio];
						}

						if (is_null($mes_confirmacao->programa_para_confirmar)) {
					
							$meses_inicio[$mes_confirmacao->id_inicio_programa] = $array_months[$mes_confirmacao->mes_inicio];
						}
					}
				}
			}

			if (!$libera_tela) {
				return redirect()->back();
			}

			$nome = User::find($id_user)->nome;

			$programa_pos = new ProgramaPos();

			$nome_programa_pretendido = $programa_pos->pega_programa_pos_mat($status_selecao->programa_pretendido, $locale_candidato);

			$dados_para_template['id_candidato'] = $id_user;

			$dados_para_template['id_inscricao_pos'] = $id_inscricao_pos;

			$dados_para_template['nome'] = $nome;
			
			$dados_para_template['programa_pretendido'] = $nome_programa_pretendido;

			return view('templates.partials.candidato.confirma_presenca',compact('dados_para_template', 'meses_inicio'));

		}else{
			
			return redirect()->back();
		}
	}

	public function postConfirmaPresenca(Request $request)
	{	

		$id_candidato = (int)$request->id_candidato;

		$id_inscricao_pos = (int)$request->id_inscricao_pos;
		
		$configura_inicio = new ConfiguraInicioPrograma();

		$libera_tela = $configura_inicio->libera_tela_confirmacao($id_inscricao_pos);

		if ($libera_tela) {
			
			if (isset($request->id_inicio_programa)) {

				$id_inicio_programa = (int)$request->id_inicio_programa;
			}else{
			
				$id_inicio_programa = null;
			}

			if (isset($request->confirma)) {
			
				$confirmou_presenca = True;
			}else{
			
				$confirmou_presenca = False;
			}

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

				if ($status_selecao->confirmou_presenca) {

					notify()->flash(trans('mensagens_gerais.confirmou_presenca'),'success');
				
					return redirect()->route('home');
				}

				$data_hoje = (new Carbon())->format('Y-m-d');

				if (is_null($id_inicio_programa)) {
					
					$mes_escolhido = new ConfiguraInicioPrograma();

					$prazo_confirmacao = $mes_escolhido->retorna_meses_para_inicio($id_inscricao_pos)[1]->prazo_confirmacao;
				}else{

					$mes_escolhido = ConfiguraInicioPrograma::find($id_inicio_programa);

					$prazo_confirmacao = $mes_escolhido->prazo_confirmacao;
				}
				
				if ($data_hoje <= $prazo_confirmacao) {
					
					$status_resposta = $selecionado->grava_resposta_participacao($id_candidato, $id_inscricao_pos, $confirmou_presenca, $id_inicio_programa);

					if ($confirmou_presenca) {
						
						$inicia_documentos_matricula = new DocumentoMatricula();
						
						$inicia_documentos_matricula->id_candidato = $id_candidato;
						
						$inicia_documentos_matricula->id_inscricao_pos = $id_inscricao_pos;
						
						$inicia_documentos_matricula->tipo_arquivo = 'df';
						
						$inicia_documentos_matricula->nome_arquivo = NULL;
        				
        				$inicia_documentos_matricula->arquivo_final = False;

        				$inicia_documentos_matricula->save();
					}
				}else{
					
					notify()->flash(trans('mensagens_gerais.presenca_erro_fora_prazo'),'error');
				
					return redirect()->route('home');
				}
				

				if ($status_resposta) {
					
					notify()->flash(trans('mensagens_gerais.confirma_presenca'),'success');
				
					return redirect()->route('home');
				}else{
					
					notify()->flash(trans('mensagens_gerais.confirmou_presenca_erro'),'error');
				
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