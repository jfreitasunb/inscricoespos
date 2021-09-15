<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\App;

use Session;

class LoginController extends Controller
{

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        App::setLocale(Session::get('locale'));

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logar(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()->hasRole('admin')) {
            return redirect()->intended(RouteServiceProvider::ADMIN);
        }

        if (Auth::user()->hasRole('coordenador')) {
            return redirect()->intended(RouteServiceProvider::COORD);
        }

        if (Auth::user()->hasRole('candidato')) {
            return redirect()->intended(RouteServiceProvider::CAND);
        }

        if (Auth::user()->hasRole('recomendante')) {
            return redirect()->intended(RouteServiceProvider::RECO);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
