<?php

namespace Posmat\Http\Controllers\Coordenador;

use Auth;
use DB;
use Mail;
use Session;
use File;
use PDF;
use Notification;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\CartaRecomendacao;
use Posmat\Models\Formacao;
use Posmat\Models\ProgramaPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\BaseController;
use Posmat\Http\Controllers\CidadeController;
use Posmat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
* Classe para visualização da página inicial.
*/
class ConfiguraInscricaoPosController extends CoordenadorController
{

	public function getConfiguraInscricaoPos()
	{

		$inscricao_pos = new ConfiguraInscricaoPos();

		$programas_pos_mat = ProgramaPos::get()->all();

		return view('templates.partials.coordenador.configurar_inscricao')->with(compact('programas_pos_mat'));
	}

	public function postConfiguraInscricaoPos(Request $request)
	{

		$this->validate($request, [
			'inicio_inscricao' => 'required|date_format:"d/m/Y"|before:fim_inscricao|after:today',
			'fim_inscricao' => 'required|date_format:"d/m/Y"|after:inicio_inscricao|after:today',
			'prazo_carta' => 'required|date_format:"d/m/Y"|after:inicio_inscricao|after:today',
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

    	$data_inicio = $inicio->format('Y-m-d');
    	$data_fim = $fim->format('Y-m-d');
    	$prazo_carta = $prazo->format('Y-m-d');


    	if ($configura_nova_inscricao_pos->autoriza_configuracao_inscricao($data_inicio)) {

    		$configura_nova_inscricao_pos->inicio_inscricao = $data_inicio;
			$configura_nova_inscricao_pos->fim_inscricao = $data_fim;
			$configura_nova_inscricao_pos->prazo_carta = $prazo_carta;
			$configura_nova_inscricao_pos->edital = $request->edital_ano."-".$request->edital_numero;
			$configura_nova_inscricao_pos->programa = implode("_", $request->escolhas_coordenador);
			$configura_nova_inscricao_pos->id_coordenador = $user->id_user;

			$temp_file = $request->edital->store("arquivos_temporarios");

        	$nome_temporario_edital = $local_documentos.$temp_file;

	        $nome_final_edital = $arquivos_editais."Edital_MAT_".$configura_nova_inscricao_pos->edital.".pdf";

			if (File::copy($nome_temporario_edital,$nome_final_edital)) {
				
				File::delete($nome_temporario_edital);
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