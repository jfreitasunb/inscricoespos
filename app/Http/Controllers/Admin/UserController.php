<?php

namespace Posmat\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Posmat\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
    	return view('templates.partials.admin.users.index');
    }
}
