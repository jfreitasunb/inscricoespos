<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
use App;

use Illuminate\Http\Request;

class IdiomaSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');

            App::setLocale($locale);
        } else{
            App::setLocale('pt_BR');
        }

        return $next($request);
    }
}
