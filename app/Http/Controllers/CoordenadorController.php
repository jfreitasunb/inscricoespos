<?php

namespace Posmat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Carbon\Carbon;
use Posmat\Models\User;
use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\AreaPosMat;
use Posmat\Models\ProgramaPosMat;
use Posmat\Models\RelatorioController;
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

	public function getConfiguraMonitoria()
	{

		$monitoria = new ConfiguraInscricaoPos();

		$disciplina = new AreaPosMat();

		$disciplinas = $disciplina->pega_disciplinas_monitoria();

		return view('templates.partials.coordenador.configurar_monitoria')->with('disciplinas', $disciplinas);
	}

	public function postConfiguraMonitoria(Request $request)
	{

		$this->validate($request, [
			'inicio_inscricao' => 'required|date_format:"d/m/Y"|before:fim_inscricao|after:today',
			'fim_inscricao' => 'required|date_format:"d/m/Y"|after:inicio_inscricao|after:today',
			'semestre' => 'required',
			'escolhas_coordenador' => 'required',
		]);

		$user = Auth::user();
    
    	$inicio = Carbon::createFromFormat('d/m/Y', $request->inicio_inscricao);
    	$fim = Carbon::createFromFormat('d/m/Y', $request->fim_inscricao);

    	$data_inicio = $inicio->format('Y-m-d');
    	$data_fim = $fim->format('Y-m-d');

    	$ano = $inicio->format('Y');

    	$monitoria = new ConfiguraInscricaoPos();

		$monitoria->ano_monitoria = $ano;
		$monitoria->semestre_monitoria = $request->semestre;
		$monitoria->inicio_inscricao = $data_inicio;
		$monitoria->fim_inscricao = $data_fim;
		$monitoria->id_coordenador = $user->id_user;

		$monitoria->save();

		$id_monitoria=$monitoria->id_monitoria;

		for ($i=0; $i < sizeof($request->escolhas_coordenador); $i++) { 

			$disciplinamonitoria = new ProgramaPosMat;

			$disciplinamonitoria->id_monitoria = $id_monitoria;
			
			$disciplinamonitoria->codigo_disciplina = $request->escolhas_coordenador[$i];

			$disciplinamonitoria->save();

		}

		notify()->flash('Dados gravados com sucesso.','info');
		return redirect()->route('configura.monitoria');

		

	}

	public function getRelatorioMonitoria()
	{

		return view('templates.partials.coordenador.relatorio_monitoria');
	}

}