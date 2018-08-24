<?php

namespace InscricoesPos\Http\Controllers;

use InscricoesPos\Models\{ConfiguraInscricaoPos, User};
use Auth;
use Session;

use View;



/**
* Classe base.
*/

class BaseController extends Controller
{

	public $periodo_inscricao;

    public $texto_inscricao_pos;

	public function __construct() {

       $inscricao_pos = new ConfiguraInscricaoPos();

	   $periodo_inscricao = $inscricao_pos->retorna_periodo_inscricao();

       $texto_inscricao_pos = $inscricao_pos->define_texto_inscricao();

       // dd($texto_inscricao_pos);

       View::share ( 'periodo_inscricao', $periodo_inscricao );

       View::share ( 'texto_inscricao_pos', $texto_inscricao_pos );
    }

    public function SetUser()
    {
        if (session()->has('impersonate')) {
            
            return User::find(session()->get('impersonate'));
        }else{
            return Auth::user();
        }
    }
}
