<?php

namespace InscricoesPos\Console\Commands;

use Illuminate\Console\Command;

use InscricoesPos\Models\DocumentoMatricula;
use InscricoesPos\Models\Documento;

class LimpezaArquivosAntigos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limpa:arquivos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove arquivos com mais de 5 anos.';

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
        $documentos = new Documento();

        $arquivos_enviados = $documentos->retorna_arquivo_para_limpeza();

        foreach ($arquivos_enviados as $arquivo) {
            dd($arquivo);
        }
        echo "rodei";
    }
}
