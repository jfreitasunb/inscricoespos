<?php

namespace App\Http\Controllers\Coordenador;

use App\Http\Controllers\Controller;
use App\Http\Models\ProgramaPos;
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
}
