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
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('mensagens_gerais.carta_recomendacao'))
            ->line(trans('mensagens_gerais.motivo_mensagem'))
            ->line('A ativação é necessária para poder efetuar login no sistema.')
            ->action('Clique no link',  'para que sua conta seja ativada.')
            ->line('Se você não criou nenhuma conta, por favor ignore essa mensagem.');
    }
}
