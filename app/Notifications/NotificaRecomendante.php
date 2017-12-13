<?php

namespace Posmat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotificaRecomendante extends Notification
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
            ->from('posgrad@mat.unb.br', 'Coordenação de Pós-Graduação do MAT/UnB')
            ->subject(trans('mensagens_gerais.carta_recomendacao'))
            ->line(trans('mensagens_gerais.motivo_mensagem_1').$this->dados_email['nome_professor'].',')
            ->line(trans('mensagens_gerais.motivo_mensagem_2').$this->dados_email['programa'].trans('mensagens_gerais.motivo_mensagem_3').$this->dados_email['nome_candidato'].'.')
            ->line(trans('mensagens_gerais.motivo_mensagem_4').url('/'))
            ->line(trans('mensagens_gerais.motivo_mensagem_5').$this->dados_email['email_recomendante'])
            ->line(trans('mensagens_gerais.prazo_envio').$this->dados_email['prazo_envio'].'.')
            ->action(trans('mensagens_gerais.recupera_senha'),url('esqueci/senha'))
            ->line(trans('mensagens_gerais.saudacoes_finais'));
    }
}
