<?php

namespace InscricoesPos\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\RememberRecomendante::class,
        Commands\RememberCandidadoFimPrazo::class,
        Commands\LimpezaArquivosAntigos::class,
        Commands\LimpezaArquivosTemporarios::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath="/home/vagrant/remember_recomendante.log";

        $filePath2="/home/vagrant/remember_candidato.log";

        $filePath3="/home/vagrant/limpeza_arquivos_antigos.log";

        $filePath4="/home/vagrant/limpeza_arquivos_temporarios.log";


        $schedule->command('remember:recomendante')
                 ->everyMinute()
                 ->sendOutputTo($filePath);

        $schedule->command('remember:candidato')
                 ->everyMinute()
                 ->sendOutputTo($filePath2);

        $schedule->command('limpa:arquivos')
                 ->dailyAt('02:00')
                 ->sendOutputTo($filePath3);

        $schedule->command('limpa:temporarios')
                 ->everyMinute()
                 ->sendOutputTo($filePath4);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
