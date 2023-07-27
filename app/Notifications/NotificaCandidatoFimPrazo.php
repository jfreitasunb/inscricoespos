<?php

namespace InscricoesPos\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotificaCandidatoFimPrazo extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $dados_email = [];

    public function __construct(array $dados_email)
    {
        $this->dados_email = $dados_email;


    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('posgrad@mat.unb.br', trans('mensagens_gerais.comite'))
            ->subject(trans('mensagens_gerais.inscricao_mat'))
            ->line(trans('mensagens_gerais.inscricao_mat_1').$this->dados_email['nome_candidato'].',')
            ->line(trans('mensagens_gerais.inscricao_nao_finalizada').$this->dados_email['fim_inscricao'].'.')
            ->action(trans('mensagens_gerais.acesso_para_finalizada'), url('/'))
            ->line(trans('mensagens_gerais.recupera_senha').url('esqueci/senha'))
            ->line(trans('mensagens_gerais.saudacoes_finais'));
    }
}
