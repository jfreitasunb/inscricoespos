<?php

namespace InscricoesPos\Providers;

use Illuminate\Support\ServiceProvider;
use InscricoesPos\Models\ConfiguraInscricaoPos;


class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {

        view()->composer('templates.partials.cabecalho', function($view)
            {
                $periodo = new ConfiguraInscricaoPos();

                $periodo_inscricao = $periodo->retorna_periodo_inscricao();

                $texto_inscricao_pos = $periodo->define_texto_inscricao();
        
                $view->with(compact('periodo_inscricao', 'texto_inscricao_pos'));
            });
    }

    public function register()
    {
    }
}
