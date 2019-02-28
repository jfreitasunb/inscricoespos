<?php

namespace InscricoesPos\Console\Commands;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Notification;
use InscricoesPos\Models\{User, ConfiguraInscricaoPos, FinalizaInscricao};
use InscricoesPos\Notifications\NotificaCandidatoFimPrazo;

use Illuminate\Console\Command;

class RememberCandidadoFimPrazo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reme:candidato';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lembra os candidatos que não finalizaram a inscrições do prazo para fazê-lo.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function checa_envio_anterior($id_candidato, $id_inscricao_pos)
    {
        $searchthis = $id_candidato.";".$id_inscricao_pos;
        
        $matches = array();

        $handle = @fopen(storage_path('app/')."candidatos_notificados.csv", "r");
        
        if ($handle)
        {
            while (!feof($handle))
            {
                $buffer = fgets($handle);
                if(strpos($buffer, $searchthis) !== FALSE)
                    $matches[] = $buffer;
            }
            fclose($handle);
        }
        
        if (sizeof($matches) > 0) {

            return TRUE;

        }else{
            return FALSE;
        }
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

        $id_inscricao_pos = $edital_vigente->id_inscricao_pos;

        $fim_inscricao = Carbon::createFromFormat('Y-m-d', $edital_vigente->fim_inscricao);

        $data_hoje = Carbon::now();

        $dados_email['fim_inscricao'] = $fim_inscricao->format('d/m/Y');

        $locale = 'en';

        if (($data_hoje->diffInDays($fim_inscricao) > 0) AND ($data_hoje->diffInDays($fim_inscricao) <= 3)) {
            
            $candidatos_nao_finaliados = (new FinalizaInscricao())->retorna_registros_tabela_finaliza_inscricao($id_inscricao_pos);

            $enviar_email = FALSE;

            foreach ($candidatos_nao_finaliados as $candidato) {
                $finalizou = $candidato->finalizada;
                
                if (!$finalizou) {
                    $enviar_email = TRUE;

                    $id_candidato = $candidato->id_candidato;

                    $ja_enviou_antes = $this->checa_envio_anterior($id_candidato, $id_inscricao_pos);
                }

                if (!$ja_enviou_antes  AND $enviar_email) {
                    
                    $dados_email['nome_candidato'] = User::find($candidato->id_candidato)->nome;
                
                    Notification::send(User::find($id_candidato), new NotificaCandidatoFimPrazo($dados_email));

                    $handle = @fopen(storage_path('app/')."candidatos_notificados.csv", "a");

                    $txt = $id_candidato.";".$id_inscricao_pos;
        
                    fwrite($handle, $txt."\n");
        
                    fclose($handle);
                }

            }
        }
    }
}
