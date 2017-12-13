<?php

namespace Posmat\Console\Commands;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Notification;
use Posmat\Models\{User, ConfiguraInscricaoPos, DadoRecomendante, CartaRecomendacao};

use Illuminate\Console\Command;

class RememberRecomendante extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reme:reco';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lembra os recomendantes do prazo final de envio das cartas.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $edital = new ConfiguraInscricaoPos;

        $edital_vigente = $edital->retorna_inscricao_ativa();

        $prazo_carta = $edital_vigente->prazo_carta;

        $this->info($prazo_carta);

        $cartas = new CartaRecomendacao;

        $cartas_nao_enviadas = $cartas->retorna_carta_recomendacao_nao_enviadas($edital_vigente->id_inscricao_pos);

        dd($cartas_nao_enviadas);
    }
}
