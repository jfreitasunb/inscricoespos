<?php

namespace App\Http\Controllers\Coordenador;

use App\Models\DadosCoordenadorPos;

use Illuminate\Http\Request;

class DadosCoordenadorPosController extends CoordenadorController
{
    public function getDadosCoordenadorPos()
	{

      	return view('layouts.coordenador.dados_coordenador_pos');
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

		$coordenador = new DadosCoordenadorPos();

		$coordenador->nome_coordenador = $nome_coordenador;

		$coordenador->tratamento = $tratamento;

		$coordenador->save();

        return redirect()->route('dados.coordenador.pos')->with('success', 'Dados salvos com sucesso.');

	}
}
