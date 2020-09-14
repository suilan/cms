<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Channels\WhatsAppChannel;
use App\Channels\Messages\WhatsAppMessage;

use App\ArquivoBoletoDet;

class ProcessamentoTitulo extends Notification
{
    use Queueable;

    public $titulo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($titulo) {
        $this->titulo = $titulo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable) {
        $nomeSacado  = trim($this->titulo->nome_sacado);
        $nomeCedente = trim($this->titulo->nome_cedente);
        $vencimentoTitulo = trim($this->titulo->data_vencimento_titulo);
        
        return (new WhatsAppMessage)
            ->content("Olá, {$nomeSacado}. Um título informado pelo {$nomeCedente}, com vencimento para {$vencimentoTitulo}. Para mais detalhes, acesse: https://2protestoslz.com.br");
  }
}
