<?php

namespace Monitoriamat\Http\Controllers;

use Auth;
use DB;
use Mail;
use Session;
use Carbon\Carbon;
use Monitoriamat\Models\User;
use Monitoriamat\Models\ConfiguraInscricao;
use Monitoriamat\Models\DisciplinaMat;
use Monitoriamat\Models\DisciplinaMonitoria;
use Monitoriamat\Models\RelatorioController;
use Illuminate\Http\Request;
use Monitoriamat\Mail\EmailVerification;
use Monitoriamat\Http\Controllers\Controller;
use Monitoriamat\Http\Controllers\AuthController;
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
    
    	$nova_disciplina = new DisciplinaMat();

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

		$monitoria = new ConfiguraInscricao();

		$disciplina = new DisciplinaMat();

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

    	$monitoria = new ConfiguraInscricao();

		$monitoria->ano_monitoria = $ano;
		$monitoria->semestre_monitoria = $request->semestre;
		$monitoria->inicio_inscricao = $data_inicio;
		$monitoria->fim_inscricao = $data_fim;
		$monitoria->id_coordenador = $user->id_user;

		$monitoria->save();

		$id_monitoria=$monitoria->id_monitoria;

		for ($i=0; $i < sizeof($request->escolhas_coordenador); $i++) { 

			$disciplinamonitoria = new DisciplinaMonitoria;

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