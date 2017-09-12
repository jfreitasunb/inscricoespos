<?php

namespace Posmat\Http\Controllers;

use Posmat\Models\ConfiguraInscricaoPos;

use View;



/**
* Classe base.
*/

class BaseController extends Controller
{

	public $periodo_inscricao;

	public function __construct() {

       $inscricao_pos = new ConfiguraInscricaoPos();

	   $periodo_inscricao = $inscricao_pos->retorna_periodo_inscricao();

       View::share ( 'periodo_inscricao', $periodo_inscricao );
    }
}
