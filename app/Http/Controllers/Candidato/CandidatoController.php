<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\BaseController;

use Illuminate\Http\Request;

use App\Models\Paises;
use App\Models\Estados;
use App\Http\Models\Cidades;

use App;

use Auth;

use Session;

class CandidatoController extends BaseController
{
	private $estadoModel;

    public function __construct(Estado $estado)
    {
        $this->estadoModel = $estado;
    }

    public function getCidades($idEstado)
    {
        $estado = $this->estadoModel->find($idEstado);

        $cidades = $estado->cidades()->getQuery()->get(['id', 'cidade']);

        return Response::json($cidades);
    }

    public $locale_default = 'pt_BR';

    public function getMenu()
    {
        Session::get('locale');

        return view('layouts.app');
    }
}
