<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App;

use Auth;

use Session;

class AdminController extends Controller
{

    public $locale_default = 'pt_BR';

    public function getMenu()
    {
        Session::get('locale');

        return view('layouts.app');
    }

    public function getConfiguraInscricao()
    {
        return view('layouts.coordenador.configura_inscricao');
    }
}
