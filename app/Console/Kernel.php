<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\GerarEdital',
		'App\Console\Commands\SendMailSegundaVia',
		'App\Console\Commands\SendNotificaton',
		'App\Console\Commands\EnviaCertificadoEvento',
		'App\Console\Commands\EnviaIntimacaoEletronica',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('sendmailsegundavia')
				->weekdays()
				->timezone('America/Sao_Paulo')
				->dailyAt('20:30')
				->withoutOverlapping();
	}
}