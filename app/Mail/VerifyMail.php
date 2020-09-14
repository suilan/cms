<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Swift_SmtpTransport;
use Swift_Mailer;
use Mail;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $transport = Swift_SmtpTransport::newInstance('smtp.googlemail.com', 465, 'ssl')
        // ->setUsername('intimacao@2protestoslz.com.br')
        // ->setPassword('xzlvwfambetyisee');
        ->setUsername('atendimento@2protestoslz.com.br')
        ->setPassword('AtendimentoCartProt@2020');
        
        $gmail = Swift_Mailer::newInstance($transport);
        Mail::setSwiftMailer($gmail);

        return $this->from('intimacao@2protestoslz.com.br', '2º TABELIONATO DE PROTESTO DE SÃO LUÍS')
        ->subject(' Confirmação de cadastro')
        ->view('emails.verifyUser');
    }
}
