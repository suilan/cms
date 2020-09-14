<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Remessa;
use App\Edital;
use DB;

class GerarEdital extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:edital';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command Responsable for generate new Edital';

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
	public function fire()
	{
		// Verifies the weekends
		$diaDaSemana = date('D');
		if( $diaDaSemana=="Sat" || $diaDaSemana=="Sun"){
			$this->info('Sem editais no fim de semana.');
			exit;
		}
		
		// Holidays
		$feriado = DB::table('feriados')->where('status','=',1)
			->where('data','=',date('Y-m-d'))
			->first();
		if( $feriado ){
			$this->info('Sem editais no Feriado.');
			exit;
		}

		// Try to generate editais
		$cartoriosIDs = Remessa::whereNull('edital_id')
		->where('cancelado','=','0')
		->groupBy('cartorio_id')
		->lists('cartorio_id');

		for ( $i=0; $i < sizeof($cartoriosIDs) ; $i++ ) { 
			$cartorioId = $cartoriosIDs[$i];

		    $remessas = Remessa::whereNull('edital_id')
		        ->where('cancelado','=','0')
		        ->where('cartorio_id','=', $cartorioId)
		        ->lists('id'); 

		    $edital = new Edital;
		    $edital->cartorio_id = $cartorioId;
		    $edital->user_id = 1;
		    $edital->save();

		    Remessa::whereIn('id', $remessas)
		        ->update(['edital_id'=>$edital->id]);
		}

		$this->info( sizeof($cartoriosIDs).' Editais gerados: '.date('d/m/Y').'.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [ ];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
