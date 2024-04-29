<?php

namespace App\Http\Controllers\Coordenador;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App;

use Auth;

use Session;

class CoordenadorController extends Controller
{

    public $locale_default = 'pt_BR';

    public function getMenu()
    {   
        Session::get('locale');

        return view('layouts.app');
    }
}
