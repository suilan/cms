<?php namespace App\Console\Commands;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Console\Command;

use App\Devedor;
use App\ArquivoBoletoDet;
use App\DevedorContato;
use App\NotificacaoDevedor;

use Swift_SmtpTransport;
use Swift_Mailer;
use Mail;
use DB;

class EnviaIntimacaoEletronica extends Command {


	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviaintimacaoeletronica';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia Intimacoes Eletronicas';

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */	 
	public function fire()
	{
		$devedores = Devedor::select("arquivo_remessa_boleto_dets.id as titulo_id", "devedores.id as devedor_id")
        ->join("arquivo_remessa_boleto_dets","arquivo_remessa_boleto_dets.documento_sacado","=","devedores.documento")
        ->where("arquivo_remessa_boleto_dets.id_arquivo_boleto","=",436)
        ->whereRaw("
            exists (
                select 0 from devedor_contato dc
                where dc.devedor_id = devedores.id 
                and dc.tipo_contato = 5
            )
            and not exists (
                select 0 from notificacao_devedor nd
                where nd.devedor_id = devedores.id
                and nd.titulo_id = arquivo_remessa_boleto_dets.id
            )
        ")
        ->whereRaw('STR_TO_DATE(arquivo_remessa_boleto_dets.vencimento_boleto,"%d%m%Y") >= now()')->get();
        
        $backup = Mail::getSwiftMailer();

        $transport = Swift_SmtpTransport::newInstance('smtp.googlemail.com', 465, 'ssl')
        ->setUsername('intimacao@2protestoslz.com.br')
        ->setPassword('xzlvwfambetyisee');
        // Mailgun
        // ->setKey($key);
        // ->setDomain($domain);

        $gmail = Swift_Mailer::newInstance($transport);
        Mail::setSwiftMailer($gmail);
        
        $this->info("Iniciando processo de envios das notificacoes. (".$devedores->count().")");
        foreach ($devedores as $key => $value) {
            $devedor = Devedor::where("id",$value->devedor_id)->first();
            $titulo = ArquivoBoletoDet::where('id',$value->titulo_id)->first();
            $contatos = DevedorContato::where('devedor_id',$devedor->id)->where('tipo_contato',5)->get();

            foreach ($contatos as $key => $contato) {
                // if ($contato->tipo_contato == 5) {
                // 	$obj = new StdClass();
                // 	$obj->titulo = $titulo;
                // 	$obj->contato = $contato;

                // 	$devedor->notify(new ProcessamentoTitulo($obj));
                // } else if ($contato->tipo_contato == 5){
                    // Lembarar de modificar o corpo do e-mail

                $this->info("Email enviados para ".$contato->contato.", para o devedor ".$devedor->nome." sucesso.");

                $notificacaoDevedor = new NotificacaoDevedor;
                $notificacaoDevedor->titulo_id = $titulo->id;
                $notificacaoDevedor->devedor_id = $devedor->id;
                $notificacaoDevedor->devedor_contato_id = $contato->devedor_contato_id;
                $notificacaoDevedor->mensagem_enviada = "Mensagem enviada por e-mail";

                try {
                    Mail::send('emails.segundaViaMail', ["dados"=>$titulo], function ($message) use ($contato, $devedor) {
                        $message->from('intimacao@2protestoslz.com.br', '2º TABELIONATO DE PROTESTO DE SÃO LUÍS');
                        $message->to(trim($contato->contato), strtoupper($devedor->nome) );
                        // $message->to("christiandiniz@gmail.com", "CHRISTIAN DINIZ CARVALHO");
                        $message->subject('Intimação Eletrônica de Protesto');
                    });

                    sleep(2);
                } catch (Exception $e) {
                    $notificacaoDevedor->mensagem_enviada_resp = $e->getMessage();	
                }
                    
                $notificacaoDevedor->save();
                // }
            }
        }
        $this->info("Finalizando processo de envios das notificacoes.");
        Mail::setSwiftMailer($backup);
	}
}
