<?php

namespace InscricoesPos\Console\Commands;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Notification;
use InscricoesPos\Models\{User, ConfiguraInscricaoPos, DadoPessoalRecomendante, CartaRecomendacao, ContatoRecomendante, FinalizaInscricao};
use InscricoesPos\Notifications\EmailRememberRecomendante;

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
        $edital = new ConfiguraInscricaoPos;

        $edital_vigente = $edital->retorna_inscricao_ativa();

        $id_inscricao_pos = $edital_vigente->id_inscricao_pos;

        $prazo_carta = Carbon::createFromFormat('Y-m-d', $edital_vigente->prazo_carta);

        $cartas = new CartaRecomendacao;

        $cartas_nao_enviadas = $cartas->retorna_carta_recomendacao_nao_enviadas($id_inscricao_pos);

        $data_hoje = Carbon::now();

        $dados_email['prazo_carta'] = $prazo_carta->format('d/m/Y');

        $locale = 'en';

        if ($data_hoje->diffInDays($prazo_carta) == 2) {
           
           foreach ($cartas_nao_enviadas as $id_user) {
            
            $candidatos = (new ContatoRecomendante())->retorna_candidatos_por_recomendante($id_user, $locale);
            
            $dados_recomendantes = User::find($id_user)->nome;

            $enviar_email = FALSE;
            
            foreach ($candidatos as $candidato) {
                $finalizou = (new FinalizaInscricao())->retorna_se_finalizou($candidato->id_candidato, $id_inscricao_pos);
                
                if ($finalizou) {
                    $enviar_email = TRUE;
                }
            }
            
            if (!is_null($dados_recomendantes) AND $enviar_email) {
                $dados_email['nome_professor'] = $dados_recomendantes;
                
                Notification::send(User::find($id_user), new EmailRememberRecomendante($dados_email));
            }
           }
        }
    }
}
