<?php namespace App\Console\Commands;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Console\Command;

use App\EventoInscricao;

use PDF;
use Input;
use DB;
use Mail;

class EnviaCertificadoEvento extends Command {


	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eviacertificadoevento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia certificados dos eventos por email';

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
		// $inscritos = EventoInscricao::where('evento_id','=',15)->limit(1)->get();
		// $inscritos = EventoInscricao::where('evento_id','=',16)->limit(1)->get();
		$inscritos = EventoInscricao::where('evento_id','=',16)->whereNull('certificado')->get();

		foreach ($inscritos as $envia) {
			// Gera o PDF do certificado de participação do evento
			$pdf = PDF::loadView('emails/certificadoIBDFAM', compact('envia'));
			$pdf->setPaper('A4', 'landscape');
			// Gera o e-mail com o PDF anexado.
			Mail::send('emails.certificado',[],function($email) use ($envia, $pdf){
				$email->from('contatoieptbma@gmail.com','Certificado do evento - PROVIMENTO 88 CNJ: ATUAÇÃO DOS TABELIÃES DE NOTAS E PROTESTO NA PREVENÇÃO À LAVAGEM DE DINHEIRO');
				$email->subject('Certificado do evento - PROVIMENTO 88 CNJ: ATUAÇÃO DOS TABELIÃES DE NOTAS E PROTESTO NA PREVENÇÃO À LAVAGEM DE DINHEIRO');
				$email->to($envia->email);
				// $email->to('saulo@ielop.com');
				$email->attachData($pdf->output(), 'Certificado_PROVIMENTO_88_CNJ_'.$envia->cpf.'.pdf');
			});

			EventoInscricao::where('cpf','=', $envia->cpf)
                            ->whereNull('certificado')
                            ->update(['certificado' => 1]);
		}
	}
}
