<?php

namespace Posmat\Console\Commands;

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
        //
    }
}
