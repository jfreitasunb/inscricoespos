<?php

namespace InscricoesPos\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use InscricoesPos\Models\DocumentoMatricula;
use InscricoesPos\Models\Documento;

class LimpezaArquivosAntigos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $tempo_permanencia = 1;

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

        // $data_hoje = Carbon::now();

        $arquivos_enviados = $documentos->retorna_arquivo_para_limpeza();

        foreach ($arquivos_enviados as $arquivo) {
            
            $diferenca = Carbon::now()->diffInYears($arquivo->created_at);

            if ($diferenca > $this->tempo_permanencia) {
                echo "deletando arquivo: ".$arquivo->id;
            }
        }
        
    }
}
