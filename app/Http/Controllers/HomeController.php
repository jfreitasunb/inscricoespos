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
        return view('layouts.app');
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