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
use InscricoesPos\Models\ConfiguraInicioPrograma;
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
class ConfiguraPeriodoConfirmacaoController extends CoordenadorController
{

	public function getConfiguraPeriodoConfirmacao()
	{

		$edital = new ConfiguraInscricaoPos();

        $edital_vigente = $edital->retorna_edital_vigente();

        $edital = str_pad(explode('-', $edital_vigente->edital)[1], 2, '0', STR_PAD_LEFT)."/".explode('-', $edital_vigente->edital)[0];

		return view('templates.partials.coordenador.configurar_periodo_confirmacao')->with(compact('edital', 'edital_vigente'));
	}

	public function postConfiguraPeriodoConfirmacao(Request $request)
	{
        $user = Auth::user();

        $id_coordenador = $user->id_user;

		$this->validate($request, [
			'mes_inicio_1' => 'required',
			'prazo_confirmacao_mes_1' => 'required|date_format:"d/m/Y"|after:today',
		]);

        $id_inscricao_pos = (int)$request->id_inscricao_pos;

        $mes_inicio_1 = (int)$request->mes_inicio_1;

        $prazo_confirmacao_mes_1 = Carbon::createFromFormat('d/m/Y', $request->prazo_confirmacao_mes_1);

        $edital_vigente = ConfiguraInscricaoPos::find($id_inscricao_pos);

        $configura_inicio = new ConfiguraInicioPrograma();

        $configura_inicio->id_inscricao_pos = $id_inscricao_pos;

        $configura_inicio->mes_inicio = $mes_inicio_1;

        $configura_inicio->prazo_confirmacao = $prazo_confirmacao_mes_1;

        $configura_inicio->id_coordenador = $id_coordenador;

        $configura_inicio->save();

        dd("parou aqui");



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