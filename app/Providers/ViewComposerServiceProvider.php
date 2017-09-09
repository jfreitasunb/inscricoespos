<?php

namespace Monitoriamat\Providers;

use Illuminate\Support\ServiceProvider;
use Monitoriamat\Models\ConfiguraInscricao;


class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {

        view()->composer('templates.partials.cabecalho', function($view)
            {
                $periodo = new ConfiguraInscricao();

                $periodo_inscricao = $periodo->retorna_periodo_inscricao();

        
                $view->with('periodo_inscricao', $periodo_inscricao);
            });
    }

    public function register()
    {
    }
}
