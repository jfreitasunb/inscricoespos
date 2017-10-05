<?php

namespace Posmat\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function ( $user = null ){

            if (!$user && auth()->check()) {
                $user = auth()->user();
            }

            if (!$user) {
                return false;
            }

            return $user->isAdmin();
        });

        Blade::if('coordenador', function ( $user = null ){

            if (!$user && auth()->check()) {
                $user = auth()->user();
            }

            if (!$user) {
                return false;
            }

            return $user->isCoordenador();
        });

         Blade::if('aluno', function ( $user = null ){

            if (!$user && auth()->check()) {
                $user = auth()->user();
            }

            if (!$user) {
                return false;
            }

            return $user->isAluno();
        });

        Blade::if('recomendante', function ( $user = null ){

            if (!$user && auth()->check()) {
                $user = auth()->user();
            }

            if (!$user) {
                return false;
            }

            return $user->isRecomendante();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
