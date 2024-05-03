<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ConfiguraInscricaoPos;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('templates.partials.cabecalho', function($view)
            {
                $periodo = new ConfiguraInscricaoPos();

                $periodo_inscricao = $periodo->retorna_periodo_inscricao();

                $texto_inscricao_pos = $periodo->define_texto_inscricao();

                dd(Session::has('locale'));
        
                $view->with(compact('periodo_inscricao', 'texto_inscricao_pos'));
            });
    }
}
