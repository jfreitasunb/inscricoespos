<?php

namespace Posmat\Providers;

use Posmat\Models\ConfiguraInscricaoPos;
use Posmat\Models\FinalizaInscricao;
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

        Blade::if('liberamenu', function ( $user = null ){

            $user = auth()->user();
            $id_user = $user->id_user;

            $edital_ativo = new ConfiguraInscricaoPos();

            $id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
            $edital = $edital_ativo->retorna_inscricao_ativa()->edital;
            $autoriza_inscricao = $edital_ativo->autoriza_inscricao();

            $finaliza_inscricao = new FinalizaInscricao();

            $status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

            if ($autoriza_inscricao and !$status_inscricao) {
                return true;
            }else{
                return false;
            }         
        });

         Blade::if('statuscarta', function ( $user = null ){

            $user = auth()->user();
            $id_user = $user->id_user;

            $edital_ativo = new ConfiguraInscricaoPos();

            $id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
            $edital = $edital_ativo->retorna_inscricao_ativa()->edital;
            $autoriza_inscricao = $edital_ativo->autoriza_inscricao();

            $finaliza_inscricao = new FinalizaInscricao();

            $status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

            if ($autoriza_inscricao and $status_inscricao) {
                return true;
            }else{
                return false;
            }         
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
