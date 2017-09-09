<?php

namespace Monitoriamat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
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
            ->subject('Link para mudança de senha')
            ->line('Você está recebendo essa mensagem porquê solicitou a mudança da sua senha.')
            ->action('Mudar senha:', url('esqueci/senha', $this->token))
            ->line('Se você não solicitou a mudança da sua senha, por favor ignore essa mensagem.');
    }
}
