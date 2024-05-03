<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificaNovaInscricao extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $dados_email = [];
    
    public function __construct(array $dados_email)
    {
        $this->dados_email = $dados_email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from('posgrad@mat.unb.br', 'Coordenação de Pós-Graduação do MAT/UnB')
            ->subject('Nova inscrição configurada')
            ->line('Fique atento, uma nova inscrição da Pós começará em breve. Veja os dados abaixo: ')
            ->line('Início da inscrição: '.$this->dados_email['inicio_inscricao'])
            ->line('Fim da inscrição: '.$this->dados_email['fim_inscricao'])
            ->line('Prazo para envio das cartas: '.$this->dados_email['prazo_carta'])
            ->line('Inscrição para: '.$this->dados_email['programa']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
