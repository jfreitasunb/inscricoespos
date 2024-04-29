<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
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

        Blade::if('candidato', function ( $user = null ){

            if (!$user && auth()->check()) {
                $user = auth()->user();
            }

            if (!$user) {
                return false;
            }

            return $user->isCandidato();
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
}
