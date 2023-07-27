<?php

namespace InscricoesPos\Http\Controllers\Admin;

use Auth;
use Session;
use InscricoesPos\Models\{User, DadoCoordenadorPos};
use Illuminate\Http\Request;
use InscricoesPos\Http\Controllers\Controller;
use InscricoesPos\Http\Controllers\AuthController;
use InscricoesPos\Http\Controllers\CoordenadorController;
use InscricoesPos\Http\Controllers\DataTable\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

/**
* Classe para visualização da página inicial.
*/
class DadosCoordenadorPosController extends AdminController
{

	public function getDadosCoordenadorPos()
	{

      	return view('templates.partials.admin.dados_coordenador_pos');
	}

	public function postDadosCoordenadorPos(Request $request)
	{
		
		$this->validate($request, [
			'nome_coordenador' => 'required',
			'prof_tratamento' => 'required',
			'tipo_coord' => 'required',
		]);

		$nome_coordenador = trim($request->nome_coordenador);

		$tratamento = $request->prof_tratamento."_".$request->tipo_coord;

		$coordenador = new DadoCoordenadorPos();

		$coordenador->nome_coordenador = $nome_coordenador;

		$coordenador->tratamento = $tratamento;

		$coordenador->save();

		notify()->flash('Dados salvos com sucesso!','success', ['timer' => 3000,]);

		return redirect()->route('home');
	}
}