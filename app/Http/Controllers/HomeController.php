<?php

namespace App\Http\Controllers;

use App\Models\ConfiguraInscricaoPos;

use App\Models\User;

use Illuminate\Http\Request;

use App;

use Auth;

use Session;

class HomeController extends BaseController
{

    public function index()
    {

        return view('layouts.home');
    }
}
