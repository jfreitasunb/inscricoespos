<?php

namespace InscricoesPos\Console\Commands;

use Illuminate\Console\Command;

use InscricoesPos\Models\DocumentoMatricula;

class LimpezaArquivosTemporarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $tempo_permanencia_relatorios_editais = 2;
    
    protected $diretorios_limpar = ['app/arquivos_temporarios', 'public/storage/relatorios/temporario', 'public/storage/relatorios/arquivos_auxiliares', 'public/storage/relatorios/arquivos_internos', 'public/storage/relatorios/ficha_inscricao', 'public/storage/relatorios/matricula'];

    protected $signature = 'limpa:temporarios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove arquivos temporários.';

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
