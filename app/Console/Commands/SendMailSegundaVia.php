<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\ArquivoBoletoDet;
use App\ArquivoBoleto;

use App\Mail\SegundaViaMail;
use Illuminate\Support\Facades\Mail;
use DB;
use Carbon\Carbon;

use Swift_Mailer;
use Swift_SmtpTransport;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class SendMailSegundaVia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmailsegundavia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia E-mail notificando de novos titulos a protesto, apenas para usuários credenciados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $registros = DB::select('
                select u.name, u.email, u.cpf, u.cpf documento, u.token_notificacao, d.*
                from users u, arquivo_remessa_boleto_dets d
                where u.cpf = d.documento_sacado
                and papel_id = 8 
                and creden = 1
                and d.enviaemail = 0
                and STR_TO_DATE(d.vencimento_boleto,"%d%m%Y") >= now()
                union
                select u.name, u.email, u.cpf, r.cnpj documento, u.token_notificacao, d.*
                from users u, representante r, arquivo_remessa_boleto_dets d
                where u.id = r.user_id 
                and substr(r.cnpj,1,10) = substr(d.documento_sacado,1,10)
                and r.creden = 1
                and d.enviaemail = 0
                and STR_TO_DATE(d.vencimento_boleto,"%d%m%Y") >= now()
        ');

        $backup = Mail::getSwiftMailer();

        $transport = Swift_SmtpTransport::newInstance('smtp.googlemail.com', 465, 'ssl')
        ->setUsername('intimacao@2protestoslz.com.br')
        ->setPassword('xzlvwfambetyisee');
        // Mailgun
        // ->setKey($key);
        // ->setDomain($domain);

        $gmail = Swift_Mailer::newInstance($transport);
        Mail::setSwiftMailer($gmail);

        foreach ($registros as $envia) {
            Mail::to($envia->email)
            ->send(new SegundaViaMail($envia));
            
            $this->info("Email enviados para ".$envia->email.", para o documento ".$envia->documento." sucesso.");
            
            Mail::to("tdcar_8@icloud.com")
            ->send(new SegundaViaMail($envia));

            $this->info("Email enviados para Tarso, para o documento ".$envia->documento." sucesso.");
            
            if($envia->token_notificacao != null || $envia->token_notificacao != ''){
                sendNotificationFireBase($envia->token_notificacao);
            }

            ArquivoBoletoDet::where(DB::raw('substr(documento_sacado,1,10)'),'=', substr($envia->documento,0,10))
                            ->where('enviaemail', 0)
                            ->update(['enviaemail' => 1]);
        }

        Mail::setSwiftMailer($backup);
        $this->info("E-mails enviados com sucesso.");
    }

    public function sendNotificationFireBase($token){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('IEPTB-MA');
        $notificationBuilder->setBody('Alerta de Título a Proteto')
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }
}