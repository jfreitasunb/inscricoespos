<?php

namespace App\Http\Controllers\Coordenador;

use App\Http\Controllers\Controller;
use App\Models\ProgramaPos;
use InscricoesPos\Models\ConfiguraInscricaoPos;

use Illuminate\Http\Request;

use App;

use Auth;

use Session;

class ConfiguraInscricaoPosController extends CoordenadorController
{
    public function getConfiguraInscricao()
    {
        $programas_pos_mat = ProgramaPos::get()->all();

        return view('layouts.coordenador.configura_inscricao')->with(compact('programas_pos_mat'));
    }

    public function postConfiguraInscricao(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'inicio_inscricao' => 'required|date_format:"Y-m-d"|before:fim_inscricao|after:today',
            'fim_inscricao' => 'required|date_format:"Y-m-d"|after:inicio_inscricao|after:today',
            'prazo_carta' => 'required|date_format:"Y-m-d"|after:inicio_inscricao|after:fim_inscricao|after:today',
            'data_homologacao' => 'required|date_format:"Y-m-d"|after:fim_inscricao|after:today',
            'data_divulgacao_resultado' => 'required|date_format:"Y-m-d"|after:data_homologacao|after:today',
            'necessita_recomendante' => 'required',
            'edital_ano' => 'required',
            'edital_numero' => 'required',
            'escolhas_coordenador' => 'required',
        ]);
    }
}
