<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;

use App;

use Auth;

use Session;

class AdminController extends BaseController
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
