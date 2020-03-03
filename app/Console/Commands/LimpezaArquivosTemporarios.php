<?php

namespace InscricoesPos\Console\Commands;

use Illuminate\Console\Command;

use InscricoesPos\Models\ConfiguraInscricaoPos;
use File;
use Storage;
use Carbon\Carbon;

class LimpezaArquivosTemporarios extends Command
{
    /**
     * Caminho base
     */
    
    // protected $caminho_base = "/var/www/inscricoespos/storage/app/";
    /**
     * Tempo em meses que os arquivos de um dado edital serão mantidos no servidor.
     */
    
    protected $tempo_permanencia_relatorios_editais = 8;

    /**
     * Lista de diretórios a serem limpos.
     */
    
    protected $diretorios_limpar = ['arquivos_temporarios', 'relatorios/temporario', 'relatorios/arquivos_auxiliares', 'relatorios/arquivos_internos', 'relatorios/ficha_inscricao', 'relatorios/matricula'];

    // protected $diretorios_limpar = ['arquivos_temporarios'];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */

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
        //File::isDirectory($locais_arquivos['ficha_inscricao']) or File::makeDirectory($locais_arquivos['ficha_inscricao'],0775,true);
        
        $editais = new ConfiguraInscricaoPos();

        $editais_presentes = $editais->retorna_editais_para_limpeza();

        foreach ($editais_presentes as $edital) {

            $diferenca = Carbon::now()->diffInMonths($edital->fim_inscricao);

            if ($diferenca > $this->tempo_permanencia_relatorios_editais) {
                echo "Removendo arquivos do edital: ".$edital->edital."\n";
            }
        }


        // foreach ($this->diretorios_limpar as $diretorio) {

        //     if (File::isDirectory(storage_path($diretorio))) {

        //         Storage::deleteDirectory($diretorio);

        //         // File::makeDirectory($endereco_diretorio, 0775, TRUE);
        //     }
        // }
    }
}
