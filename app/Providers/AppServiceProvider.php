<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $periodo_inscricao = "26/05/2021 à 13/06/2021";

        $texto_inscricao_pos = "dois_programas";

        View::share ( 'periodo_inscricao', $periodo_inscricao );

        View::share ( 'texto_inscricao_pos', $texto_inscricao_pos );
    }
}
