<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Providers\RouteServiceProvider;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use App\Models\User;
use App\Models\Role;
use App\Models\RoleUsuario;

class RegistrarController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function registrar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed'],
        ]);

        $candidato = Role::where('nome', 'candidato')->first();

        $user = User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'locale' => 'pt_BR',
        ]);

        $user->roles()->attach($candidato);

        event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME)->with('register_success', 'Um e-mail de confirmação foi enviado para o endereço fornecido. Antes de entrar você precisa confirmar seu e-mail.');
        // 
        
        return redirect(RouteServiceProvider::HOME)->with('status', 'verification-link-sent');

    }
}
