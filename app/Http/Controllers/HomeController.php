<?php

namespace Monitoriamat\Http\Controllers;

use Auth;


/**
* Classe para visualização da página inicial.
*/
class HomeController extends BaseController
{
	
	public function __construct(){
       parent::__construct();
    }

	public function index()
	{
		return view('home');
	}
}