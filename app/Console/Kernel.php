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


        $schedule->command('remember:recomendante')
                 ->everyMinute()
                 ->sendOutputTo($filePath);
        $schedule->command('remember:candidato')
                 ->everyMinute()
                 ->sendOutputTo($filePath2);
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
