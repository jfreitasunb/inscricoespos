<?php

namespace Posmat\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Posmat\Http\Controllers\Controller;

class ImpersonateController extends Controller
{
    public function index()
    {

    	return view('templates.partials.admin.impersonate');

    }

    public function store(Request $request)
    {

    	$this->validate($request, [
    		'email' => 'required|email|exists:users',
    	]);
    }
}
