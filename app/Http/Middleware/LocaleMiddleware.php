<?php

namespace Posmat\Http\Middleware;

use Closure, Session, Auth;

class LocaleMiddleware {


    public function handle($request, Closure $next)
    {
        if(Auth::user()){
        	App::setLocale(Auth::user()->locale);
            // app()->setLocale(LC_ALL,Auth::user()->locale);
        }elseif($locale = Session::has('locale')){
            App::setLocale($locale);
        }


        return $next($request);
    }

}