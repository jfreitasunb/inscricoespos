<?php

namespace Monitoriamat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AtivaConta extends Notification
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
            ->subject('Link para ativação da conta')
            ->line('Você está recebendo essa mensagem porquê você acabou de criar uma conta em nosso sistema.')
            ->line('A ativação é necessária para poder efetuar login no sistema.')
            ->action('Clique no link', url('register/verify', $this->token), 'para que sua conta seja ativada.')
            ->line('Se você não criou nenhuma conta, por favor ignore essa mensagem.');
    }
}
