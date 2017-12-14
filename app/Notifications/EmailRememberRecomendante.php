<?php

namespace Posmat\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailRememberRecomendante extends Notification
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

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('posgrad@mat.unb.br', 'Coordenação de Pós-Graduação do MAT/UnB')
                    ->subject('Prazo de envio das cartas de Recomendação ao MAT/UnB')
                    ->line('Prezado(a) recomendante '.$this->dados_email['nome_professor'].',')
                    ->line('O prazo de envio das cartas de recomendação termina no dia '.$this->dados_email['prazo_carta'].'.')
                    ->action('Para enviar as cartas clique aqui', url('/'))
                    ->line('Caso preciso mudar a senha clique no link'.url('esqueci/senha'))
                    ->line('Atenciosamente,')
                    ->line('Coordenação de Pós-Graduação do MAT/UnB.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
