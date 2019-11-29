<?php

namespace InscricoesPos\Providers;

use InscricoesPos\Models\ConfiguraInscricaoPos;
use InscricoesPos\Models\FinalizaInscricao;
use InscricoesPos\Models\CandidatosSelecionados;
use InscricoesPos\Models\ConfiguraInicioPrograma;
use InscricoesPos\Models\ConfiguraEnvioDocumentosMatricula;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    private $accordion_configurar_edital = ['configura.inscricao', 'configura.periodo.confirmacao', 'configura.periodo.matricula', 'editar.inscricao', 'editar.periodo.confirmacao', 'editar.periodo.envio.documentos.matricula'];

    private $accordion_contas = ['lista.edita.usuarios', 'pesquisa.email.muda.senha', 'admin.impersonate', 'pesquisa.usuario', 'criar.coordenador', 'lista.inativos', 'associa.recomendantes', 'visualiza.associacoes', 'conta.cartas.recomendante'];

    private $accordion_dados_pos = ['dados.coordenador.pos', 'cadastra.area.pos',  'editar.area.pos', 'editar.formacao', 'pesquisa.candidato'];

    private $accordion_acompanhar_inscricoes = ['lista.recomendacoes', 'gera.ficha.individual', 'auxilia.selecao', 'reativar.candidato', 'pesquisa.carta', 'altera.recomendante', 'pesquisa.indicacoes',  'reativar.carta', 'inscricoes.nao.finalizadas', 'lista.recomendacoes', 'link.acesso'];

    private $accordion_relatorios = [ 'relatorio.atual', 'relatorio.anteriores'];

    private $accordion_processo_selecao = ['seleciona.candidatos', 'homologa.inscricoes'];

    private $accordion_acompanha_selecionados = ['status.selecionados', 'coordenador.documentos.matricula'];

    public function ativa_accordion_acompanha_selecionado()
    {
        if (in_array(Route::currentRouteName(), $this->accordion_acompanha_selecionados)) {
            return 'in';
        }else{
            return '';
        }
    }

    public function ativa_accordion_processo_selecao()
    {
        if (in_array(Route::currentRouteName(), $this->accordion_processo_selecao)) {
            return 'in';
        }else{
            return '';
        }
    }

    public function ativa_accordion_configura_edital()
    {
        if (in_array(Route::currentRouteName(), $this->accordion_configurar_edital)) {
            return 'in';
        }else{
            return '';
        }
    }

    public function ativa_accordion_acompanhar_inscricoes()
    {
        if (in_array(Route::currentRouteName(), $this->accordion_acompanhar_inscricoes)) {
            return 'in';
        }else{
            return '';
        }
    }

    public function ativa_accordion_contas()
    {
        if (in_array(Route::currentRouteName(), $this->accordion_contas)) {
            return 'in';
        }else{
            return '';
        }
    }

    public function ativa_accordion_dados_pos()
    {
        if (in_array(Route::currentRouteName(), $this->accordion_dados_pos)) {
            return 'in';
        }else{
            return '';
        }
    }

    public function ativa_accordion_relatorios()
    {
        if (in_array(Route::currentRouteName(), $this->accordion_relatorios)) {
            return 'in';
        }else{
            return '';
        }
    }

    public function boot()
    {
        Blade::if('impersonating_recomendante', function () {

            if (session()->has('impersonate') || session()->has('impersonate_user_type')) {
                if (session()->get('impersonate_user_type') === 'recomendante') {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        });

        Blade::if('impersonating_candidato', function () {

            if (session()->has('impersonate') || session()->has('impersonate_user_type')) {
                if (session()->get('impersonate_user_type') === 'candidato') {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            
        });

        Blade::if('admin', function ( $user = null ){

            if (!$user && auth()->check()) {
                $user = auth()->user();
            }

            if (!$user) {
                return false;
            }

            View::share('keep_open_accordion_contas', $this->ativa_accordion_contas());
            
            View::share('keep_open_accordion_dados_pos', $this->ativa_accordion_dados_pos());

            View::share('keep_open_accordion_relatorios', $this->ativa_accordion_relatorios());

            return $user->isAdmin();
        });

        Blade::if('coordenador', function ( $user = null ){

            if (!$user && auth()->check()) {
                $user = auth()->user();
            }

            if (!$user) {
                return false;
            }

            View::share('keep_open_accordion_configurar_edital', $this->ativa_accordion_configura_edital());

            View::share('keep_open_accordion_acompanhar_inscricoes', $this->ativa_accordion_acompanhar_inscricoes());
            
            View::share('keep_open_accordion_dados_pos', $this->ativa_accordion_dados_pos());

            View::share('keep_open_accordion_relatorios', $this->ativa_accordion_relatorios());

            View::share('keep_open_accordion_processo_selecao', $this->ativa_accordion_processo_selecao());

            View::share('keep_open_accordion_acompanha_selecionados', $this->ativa_accordion_acompanha_selecionado());

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

        Blade::if('liberacarta', function ( $user = null ){

            $user = auth()->user();
            $id_user = $user->id_user;

            $edital_ativo = new ConfiguraInscricaoPos();

            $autoriza_preenchimento_carta = $edital_ativo->autoriza_carta();


            if ($autoriza_preenchimento_carta) {
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
            $autoriza_status_carta = $edital_ativo->visualiza_status_carta();

            $finaliza_inscricao = new FinalizaInscricao();

            $status_inscricao = $finaliza_inscricao->retorna_inscricao_finalizada($id_user,$id_inscricao_pos);

            if ($autoriza_status_carta and $status_inscricao) {
                return true;
            }else{
                return false;
            }         
        });

        Blade::if('confirmacao_participacao', function ( $user = null ){

            $user = auth()->user();
            $id_user = $user->id_user;

            $edital_ativo = new ConfiguraInscricaoPos();

            $id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
            
            $selecao_candidatos = new CandidatosSelecionados();

            $status_selecao = $selecao_candidatos->retorna_status_selecionado($id_inscricao_pos, $id_user);

            $configura_inicio = new ConfiguraInicioPrograma();

            $liberar_tela = $configura_inicio->libera_tela_confirmacao($id_inscricao_pos);
            
            if (!is_null($status_selecao)) {
                if ($status_selecao->selecionado and !$status_selecao->confirmou_presenca and $liberar_tela) {
                    return true;
                }else{
                    return false;
                }
            }
                     
        });

        Blade::if('envia_documentos_matricula', function ( $user = null ){

            $user = auth()->user();
            $id_user = $user->id_user;

            $edital_ativo = new ConfiguraInscricaoPos();

            $id_inscricao_pos = $edital_ativo->retorna_inscricao_ativa()->id_inscricao_pos;
            
            $selecao_candidatos = new CandidatosSelecionados();

            $status_selecao = $selecao_candidatos->retorna_status_selecionado($id_inscricao_pos, $id_user);

            $configura_inicio = new ConfiguraEnvioDocumentosMatricula();

            $liberar_tela = $configura_inicio->libera_tela_documento_matricula($id_inscricao_pos);
            
            if (!is_null($status_selecao)) {
                if ($status_selecao->selecionado and $status_selecao->confirmou_presenca and $liberar_tela) {
                    return true;
                }else{
                    return false;
                }
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
