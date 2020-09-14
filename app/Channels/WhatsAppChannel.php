<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
use App\NotificacaoDevedor;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {

        // var_dump();
        // exit;

        $message = $notification->toWhatsApp($notifiable);

        $to = $notifiable->routeNotificationFor('WhatsApp');
        // $to = $notification->titulo->contato->contato;

        $from = config('services.twilio.whatsapp_from');
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));        

        // $notificacaoDevedor = new NotificacaoDevedor;
        // $notificacaoDevedor->titulo_id = $notification->titulo->titulo->id;
        // $notificacaoDevedor->devedor_id = $notifiable->id;
        // $notificacaoDevedor->contato_devedor_id = $notification->titulo->contato->devedor_contato_id;
        // $notificacaoDevedor->mensagem_enviada = $message->content;
        // $notificacaoDevedor->save();

        $mensagemResp = $twilio->messages->create('whatsapp:' . $to, [
            "from" => 'whatsapp:' . "+559833036415",
            "body" => $message->content
        ]);

        var_dump($mensagemResp);
        
        // $notificacaoDevedor->url_retorno = "https://2protestoslz.com.br/api/notification/confirmamensagem/".$notificacaoDevedor->notificacao_devedor_id;
        // $notificacaoDevedor->mensagem_enviada_resp = $mensagemResp;
        // $notificacaoDevedor->mensagem_sid = $mensagemResp->sid;
        // $notificacaoDevedor->save();
    }
}