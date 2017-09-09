<?php

namespace Posmat\Http\Middleware;

use Closure, Session, Auth;

class LocaleMiddleware {


    public function handle($request, Closure $next)
    {
        if(Auth::user()){
            app()->setLocale(LC_ALL,Auth::user()->locale);
        }elseif($locale = Session::has('locale')){
            app()->setLocale(LC_ALL,$locale);
        }


        return $next($request);
    }

}