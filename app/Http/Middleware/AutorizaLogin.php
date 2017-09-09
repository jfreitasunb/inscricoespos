<?php

namespace Monitoriamat\Http\Middleware;

use Closure;
use Monitoriamat\Models\ConfiguraInscricao;

class AutorizaLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $monitoria = new ConfiguraInscricao();

        $autoriza_inscricao = $monitoria->autoriza_inscricao();

        if (!$autoriza_inscricao) {
            return redirect('/');
        }

        return $next($request);
    }
}
