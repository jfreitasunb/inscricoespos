<?php

namespace Posmat\Http\Controllers;

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
use Posmat\Models\ProgramaPos;
use Posmat\Models\FinalizaInscricao;
use Posmat\Notifications\NotificaNovaInscricao;
use Illuminate\Http\Request;
use Posmat\Mail\EmailVerification;
use Posmat\Http\Controllers\Controller;
use Posmat\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\RegistersUsers;


/**
* Classe para visualização da página inicial.
*/
class CoordenadorController extends BaseController
{

	public function getMenu()
	{	
		return view('home');
	}

	public function getCadastraDisciplina()
	{

		return view('templates.partials.coordenador.cadastra_disciplina');
	}

	public function postCadastraDisciplina(Request $request)
	{

		$this->validate($request, [
			'codigo' => 'required|unique:disciplinas_mat|numeric',
			'nome_disciplina' => 'required|max:256',
			'creditos_disciplina' => 'required|numeric',
		]);
    
    	$nova_disciplina = new AreaPosMat();

		$nova_disciplina->codigo = $request->codigo;
		$nova_disciplina->nome = $request->nome_disciplina;
		$nova_disciplina->creditos = $request->creditos_disciplina;
		
		$nova_disciplina->save();

		notify()->flash('Disciplina cadastrada com sucesso!','success',[
			'timer' => 2000,
		]);

		return redirect()->route('cadastra.disciplina');	

	}

	public function getConfiguraInscricaoPos()
	{

		$inscricao_pos = new ConfiguraInscricaoPos();

		$programas_pos_mat = ProgramaPos::get()->all();

		// $areas_pos_mat = AreaPosMat::get()->all();

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
        $arquivos_editais = public_path("/editais/");
    
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

					$temp[] = $nome_programa_pos->pega_programa_pos_mat($key);
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

	public function getRelatorioPos()
	{

		return view('templates.partials.coordenador.relatorio_pos');
	}

	public function VerFichaIndividual($nome_pdf, $id_aluno_pdf)
	{

		$user = Auth::user();
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();


		$finalizacoes = new FinalizaInscricao;

		$inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos)->paginate(2);


		return view('templates.partials.coordenador.ficha_individual', compact('inscricoes_finalizadas', 'nome_pdf', 'id_aluno_pdf'));

	}

	public function getFichaInscricaoPorCandidato()
	{

		$user = Auth::user();
		
		$relatorio = new ConfiguraInscricaoPos();

      	$relatorio_disponivel = $relatorio->retorna_edital_vigente();


		$finalizacoes = new FinalizaInscricao;

		if (session()->has('nome_pdf')) {
			$nome_pdf = session()->get('nome_pdf');
		}else{
			$nome_pdf = null;
		}

		if (session()->has('id_aluno_pdf')) {
			$id_aluno_pdf = session()->get('id_aluno_pdf');
		}else{
			$id_aluno_pdf = null;
		}
		

		$inscricoes_finalizadas = $finalizacoes->retorna_usuarios_relatorio_individual($relatorio_disponivel->id_inscricao_pos)->paginate(2);


		return view('templates.partials.coordenador.ficha_individual', compact('inscricoes_finalizadas', 'nome_pdf', 'id_aluno_pdf'));
		
	}

	public function GeraPdfFichaIndividual()
	{
		
		$user = Auth::user();
		

		$id_inscricao_pos = (int) $_GET['id_inscricao_pos'];
		
		$id_aluno_pdf = (int) $_GET['id_aluno'];

		$ficha = new RelatorioController;
	
		$nome_pdf = $ficha->geraFichaIndividual($id_aluno_pdf);
      	
      	
      	return redirect()->back()->with(compact('nome_pdf','id_aluno_pdf'));
	}



}