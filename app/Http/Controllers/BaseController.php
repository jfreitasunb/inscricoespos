<?php

namespace Posmat\Http\Controllers;

use Posmat\Models\ConfiguraInscricao;

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

    public function setLocale($locale)
    {
    	if(Auth::check()){
	     $user = User::find(Auth::user()->id);
	     $user->update(['locale'=>$locale]);
	  	}else{
	    	Session::put('locale',$locale);
	  	}
    }

    public function getLangPortuguese()
    {
    	setLocale('pt-br');
    }

    public function getLangEnglish()
    {
    	setLocale('en');
    }

    public function getLangSpanish()
    {
    	setLocale('sp');
    }
}
