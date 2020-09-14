<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

use App\Notificacoes;

class SendNotificaton extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendnotif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Teste de envio de notificação.';

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
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('IEPTB-MA');
        $notificationBuilder->setBody('Teste do novo sistema de notificacao')
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "cNcFACwTzz8:APA91bHXDTT_RVSv66TTgWGZRCC97ze7W4U1Pv0BXCyBaWa9SZ675I28el12Bnb1mRbxUOEgBOzKWFcVU037JZLeco7C7T6fLsBDHPeznbg0Oi4KvgyW63u1zLHVHF_ae4u3eKAXExBo";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $notificacao = new Notificacoes;
        $notificacao->user_id = 4;
        $notificacao->documento = null;
        $notificacao->mensagem = "Novo Título enviado a protesto.";
        $notificacao->ultima = 1;
        $notificacao->save();

        var_dump($downstreamResponse);
    }
}
