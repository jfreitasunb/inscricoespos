<?php

namespace InscricoesPos\Console\Commands;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Notification;
use InscricoesPos\Models\{User, ConfiguraInscricaoPos, DadoPessoalRecomendante, CartaRecomendacao, ContatoRecomendante, FinalizaInscricao};
use InscricoesPos\Notifications\EmailRememberRecomendante;

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

    public function checa_envio_anterior($id_candidato, $id_recomendante, $id_inscricao_pos)
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

        $prazo_carta = Carbon::createFromFormat('Y-m-d', $edital_vigente->prazo_carta);

        $cartas = new CartaRecomendacao;

        $cartas_nao_enviadas = $cartas->retorna_carta_recomendacao_nao_enviadas($id_inscricao_pos);

        $data_hoje = Carbon::now();

        $dados_email['prazo_carta'] = $prazo_carta->format('d/m/Y');

        $locale = 'en';

        if (($data_hoje->diffInDays($prazo_carta) > 0) AND ($data_hoje->diffInDays($prazo_carta) <= 3)) {
           
           foreach ($cartas_nao_enviadas as $id_user) {
            
            $candidatos = (new ContatoRecomendante())->retorna_candidatos_por_recomendante($id_user, $locale);
            
            $dados_recomendantes = User::find($id_user)->nome;

            $enviar_email = FALSE;

            foreach ($candidatos as $candidato) {
                $finalizou = (new FinalizaInscricao())->retorna_se_finalizou($candidato->id_candidato, $id_inscricao_pos);
                
                if ($finalizou) {
                    $enviar_email = TRUE;

                    $id_candidato = $candidato->id_candidato;

                    $ja_enviou_antes = $this->checa_envio_anterior($id_candidato, $id_user, $id_inscricao_pos);
                }
            }
            
            if (!is_null($dados_recomendantes) AND $enviar_email) {

                if (!$ja_enviou_antes) {
                    
                    $dados_email['nome_professor'] = $dados_recomendantes;
                
                    Notification::send(User::find($id_user), new EmailRememberRecomendante($dados_email));
                
                    DB::table('contatos_recomendantes')->where('id_candidato', $id_candidato)->where('id_inscricao_pos', $id_inscricao_pos)->where('id_recomendante', $id_user)->update(['email_enviado' => TRUE, 'updated_at' => date('Y-m-d H:i:s')]);

                    $handle = @fopen(storage_path('app/')."candidatos_notificados.csv", "a");

                    $txt = $id_candidato.";".$id_inscricao_pos;
        
                    fwrite($handle, $txt."\n");
        
                    fclose($handle);
                }
            }
           }
        }
    }
}
