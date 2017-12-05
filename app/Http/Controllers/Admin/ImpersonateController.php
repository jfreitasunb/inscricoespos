<?php

namespace Posmat\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Posmat\Http\Controllers\Controller;
use Posmat\Models\User;

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

    	$email = strtolower(trim($request->email));

    	$user = User::where('email', $email)->first();

    	session()->put('impersonate', $user->id_user);

    	return redirect('/');
    }
}
