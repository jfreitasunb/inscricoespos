<?php

namespace InscricoesPos\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;
use Storage;
use InscricoesPos\Models\Documento;

class LimpezaArquivosAntigos extends Command
{
    /**
     * Tempo em anos que os arquivos serão mantidos no servidor.
     */
    
    protected $tempo_permanencia = 5;

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

        // $data_hoje = Carbon::now();

        $arquivos_enviados = $documentos->retorna_arquivo_para_limpeza();

        foreach ($arquivos_enviados as $arquivo) {
            
            $diferenca = Carbon::now()->diffInYears($arquivo->created_at);

            if ($diferenca > $this->tempo_permanencia) {
                
                if (Storage::exists($arquivo->nome_arquivo)) {
                    
                    Storage::delete($arquivo->nome_arquivo);
                }

                $documentos->marca_arquivo_removido($arquivo->id);
            }
        }
        
    }
}
