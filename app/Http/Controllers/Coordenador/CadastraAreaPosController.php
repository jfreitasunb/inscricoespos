<?php

namespace App\Http\Controllers\Coordenador;

use App\Models\AreaPosMat;

use Illuminate\Http\Request;

class CadastraAreaPosController extends CoordenadorController
{
    public function getCadastraAreaPos()
	{
		return view('layouts.coordenador.cadastra_area_pos');
	}


	public function postCadastraAreaPos(Request $request)
	{
		$this->validate($request, [
			'nome_ptbr' => 'required',
			'nome_en' => 'required',
			'nome_es' => 'required',
		]);

		$nova_area_pos = new AreaPosMat;

		$nova_area_pos->nome_ptbr = trim($request->nome_ptbr);
		$nova_area_pos->nome_en = trim($request->nome_en);
		$nova_area_pos->nome_es = trim($request->nome_es);
		$status_gravacao = $nova_area_pos->save();

		if ($status_gravacao) {

            return redirect()->route('cadastra.area.pos')->with('success', 'Dados salvos com sucesso.');

        }else{

            return redirect()->route('cadastra.area.pos')->with('error', 'Ocorreu um erro, por favor tente novamente mais tarde.');
		}
	}
}
