<?php

namespace App\Http\Controllers\Coordenador;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App;

use Auth;

use Session;

class ConfiguraInscricaoPosController extends CoordenadorController
{
    public function getConfiguraInscricao()
    {
        return view('layouts.coordenador.configura_inscricao');
    }    
}
