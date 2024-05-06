<?php

namespace App\Http\Controllers;

use App\Models\ConfiguraInscricaoPos;

use App\Models\User;

use Illuminate\Http\Request;

use App;

use Auth;

use Session;

class HomeController extends BaseController
{

    public function index()
    {
        $periodo = new ConfiguraInscricaoPos();

        $periodo_inscricao = $periodo->retorna_periodo_inscricao();

        $texto_inscricao_pos = $periodo->define_texto_inscricao();
        
        return view('layouts.home')->with(compact('texto_inscricao_pos', 'periodo_inscricao'));
    }
}
