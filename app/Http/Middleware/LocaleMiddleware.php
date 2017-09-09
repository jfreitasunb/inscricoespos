<?php

namespace Posmat\Http\Middleware;

use Closure, Session, Auth;

class LocaleMiddleware {


    public function handle($request, Closure $next)
    {
        if(Auth::user()){
            app()->setLocale(Auth::user()->locale);
        }elseif($locale = Session::has('locale')){
            app()->setLocale($locale);
        }


        return $next($request);
    }

}