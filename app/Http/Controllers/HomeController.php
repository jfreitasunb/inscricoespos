<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $periodo_inscricao = "26/09/2021 à 31/12/2021";

        return view('layouts.app')->with('periodo_inscricao', $periodo_inscricao);
    }

    public function getLangPortugues()
    {
        App::setLocale('pt_BR');

        Session::put('locale','pt_BR');

        return redirect()->back();
    }

    public function getLangIngles()
    {
        Session::put('locale','en');

        return redirect()->back();
    }

    public function getLangEspanhol()
    {
        Session::put('locale','es');

        return redirect()->back();
    }
}
