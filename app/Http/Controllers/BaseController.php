<?php

namespace Monitoriamat\Http\Controllers;

use Monitoriamat\Models\ConfiguraInscricao;

use View;



/**
* Classe base.
*/

class BaseController extends Controller
{

	public $periodo_inscricao;

	public function __construct() {

       $monitoria = new ConfiguraInscricao();

	   $periodo_inscricao = $monitoria->retorna_periodo_inscricao();

       View::share ( 'periodo_inscricao', $periodo_inscricao );
    }  
}
