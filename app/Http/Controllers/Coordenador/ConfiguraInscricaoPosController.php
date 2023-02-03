<?php

namespace InscricoesPos\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use InscricoesPos\Models\User;
use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\AreaPosMat;
use InscricoesPos\Models\CartaRecomendacao;
use InscricoesPos\Models\Formacao;
use InscricoesPos\Models\ProgramaPos;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use InscricoesPos\Mail\EmailVerification;
use InscricoesPos\Http\Controllers\BaseController;
use InscricoesPos\Http\Controllers\CidadeController;
use InscricoesPos\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
* Classe para visualização da página inicial.
*/
class ConfiguraInscricaoPosController extends CoordenadorController
{

	public function getConfiguraInscricaoPos()
	{

		$programas_pos_mat = ProgramaPos::get()->all();

		return view('templates.partials.coordenador.configurar_inscricao')->with(compact('programas_pos_mat'));
	}

	public function postConfiguraInscricaoPos(Request $request)
	{

		$this->validate($request, [
			'inicio_inscricao' => 'required|date_format:"d/m/Y"|before:fim_inscricao|after:today',
			'fim_inscricao' => 'required|date_format:"d/m/Y"|after:inicio_inscricao|after:today',
			'prazo_carta' => 'required|date_format:"d/m/Y"|after:inicio_inscricao|after:today',
            'data_homologacao' => 'required|date_format:"d/m/Y"|after:fim_inscricao|after:today',
            'data_divulgacao_resultado' => 'required|date_format:"d/m/Y"|after:data_homologacao|after:today',
            'necessita_recomendante' => 'required',
			'edital_ano' => 'required',
			'edital_numero' => 'required',
			'escolhas_coordenador' => 'required',
		]);


		$configura_nova_inscricao_pos = new ConfiguraInscricaoPos();

		$user = Auth::user();

		$local_documentos = storage_path('app/');

        $arquivos_editais = storage_path("app/public/editais/");

        File::isDirectory($arquivos_editais) or File::makeDirectory($arquivos_editais,0775,true);
    
    	$inicio = Carbon::createFromFormat('d/m/Y', $request->inicio_inscricao);
    	$fim = Carbon::createFromFormat('d/m/Y', $request->fim_inscricao);
    	$prazo = Carbon::createFromFormat('d/m/Y', $request->prazo_carta);
        $homologacao = Carbon::createFromFormat('d/m/Y', $request->data_homologacao);
        $divulgacao_resultado = Carbon::createFromFormat('d/m/Y', $request->data_divulgacao_resultado);

        $necessita_recomendante = $request->necessita_recomendante;

    	$data_inicio = $inicio->format('Y-m-d');
    	$data_fim = $fim->format('Y-m-d');
    	$semestre_inicio = $request->semestre_inicio;
    	$prazo_carta = $prazo->format('Y-m-d');
        $data_homologacao = $homologacao->format('Y-m-d');
        $data_divulgacao_resultado = $divulgacao_resultado->format('Y-m-d');


    	if ($configura_nova_inscricao_pos->autoriza_configuracao_inscricao($data_inicio)) {

    		$configura_nova_inscricao_pos->inicio_inscricao = $data_inicio;
			$configura_nova_inscricao_pos->fim_inscricao = $data_fim;
			$configura_nova_inscricao_pos->prazo_carta = $prazo_carta;
			$configura_nova_inscricao_pos->edital = $request->edital_ano."-".$request->edital_numero;
			$configura_nova_inscricao_pos->programa = implode("_", $request->escolhas_coordenador);
			$configura_nova_inscricao_pos->id_coordenador = $user->id_user;
            $configura_nova_inscricao_pos->data_homologacao = $data_homologacao;
            $configura_nova_inscricao_pos->data_divulgacao_resultado = $data_divulgacao_resultado;
            $configura_nova_inscricao_pos->necessita_recomendante = $necessita_recomendante;
            $configura_nova_inscricao_pos->semestre_inicio = $semestre_inicio;

			$temp_file_portugues = $request->edital_portugues->store("arquivos_temporarios");

        	$nome_temporario_edital_portugues = $local_documentos.$temp_file_portugues;

	        $nome_final_edital_portugues = $arquivos_editais."Edital_MAT_".$configura_nova_inscricao_pos->edital."_ptbr.pdf";

			if (File::copy($nome_temporario_edital_portugues, $nome_final_edital_portugues)) {
				
				File::delete($nome_temporario_edital_portugues);

                if (isset($request->edital_ingles)) {
                    
                    $temp_file_ingles = $request->edital_ingles->store("arquivos_temporarios");

                    $nome_temporario_edital_ingles = $local_documentos.$temp_file_ingles;

                    $nome_final_edital_ingles = $arquivos_editais."Edital_MAT_".$configura_nova_inscricao_pos->edital."_en.pdf";

                    if (File::copy($nome_temporario_edital_ingles, $nome_final_edital_ingles)){

                        File::delete($nome_temporario_edital_ingles);
                    }
                }

                if (isset($request->edital_espanhol)) {
                    
                    $temp_file_ingles = $request->edital_espanhol->store("arquivos_temporarios");

                    $nome_temporario_edital_espanhol = $local_documentos.$temp_file_ingles;

                    $nome_final_edital_espanhol = $arquivos_editais."Edital_MAT_".$configura_nova_inscricao_pos->edital."_es.pdf";

                    if (File::copy($nome_temporario_edital_espanhol, $nome_final_edital_espanhol)){

                        File::delete($nome_temporario_edital_espanhol);
                    }
                }

				$configura_nova_inscricao_pos->save();

				$dados_email['inicio_inscricao'] = $request->inicio_inscricao;
				$dados_email['fim_inscricao'] = $request->fim_inscricao;
				$dados_email['prazo_carta'] = $request->prazo_carta;

				foreach ($request->escolhas_coordenador as $key) {
					
					$nome_programa_pos = new ProgramaPos();

					$temp[] = $nome_programa_pos->pega_programa_pos_mat($key, $this->locale_default);
				}

				$dados_email['programa'] = implode('/', $temp);

				Notification::send(User::find('1'), new NotificaNovaInscricao($dados_email));

				notify()->flash('Inscrição configurada com sucesso.','success');
				return redirect()->route('configura.inscricao');


			}else{
				notify()->flash('Houve um problema na hora de enviar o edital. Tente novamente.','error');
				return redirect()->route('configura.inscricao');
			}
    	}else{
    		notify()->flash('Já existe uma inscrição ativa para esse período.','error');
			return redirect()->back('configura.inscricao');
    	}
	}
}