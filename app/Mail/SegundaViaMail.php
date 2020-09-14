<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SegundaViaMail extends Mailable
{
    use Queueable, SerializesModels;
    public $dados;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('intimacao@2protestoslz.com.br','2° Tabelionato de Protesto de Letras e Outros Títulos de Créditos - São Luís')
        ->subject('Notificação')
        ->view('emails.segundaViaMail');    
        
    }
}
