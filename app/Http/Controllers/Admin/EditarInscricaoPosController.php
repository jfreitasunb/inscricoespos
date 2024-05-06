<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ConfiguraInscricaoPos;

use App;

use Auth;

use Session;

class EditarInscricaoPosController extends AdminController
{

    public function getEditarInscricao()
    {   
        $edital = new ConfiguraInscricaoPos();

        $edital_vigente = $edital->retorna_edital_vigente();

        return view('layouts.admin.editar_inscricao')->with(compact('edital_vigente'));
    }
}
