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
            ->line('Sua inscrição não consta como finalizada em nosso sistema. O prazo para envio termina no dia '.$this->dados_email['prazo_inscricao'].'.')
            ->action('Clique aqui para acessar o sistema e finalizar sua inscrição.', url('/'))
            ->line('Caso não lembre sua senha clique aqui '.url('esqueci/senha'))
            ->line('Sincerely,')
            ->line('Postgraduate Comitee of MAT/UnB.');
    }
}
