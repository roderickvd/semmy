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
		'App\Console\Commands\LogPVOutput',
		'App\Console\Commands\LogSonnenertrag'
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule	$schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('log:pvoutput')
				 ->everyFiveMinutes()
				 ->when(function()
						{
							return env('SCHEDULE_PVOUTPUT');
						});

		$schedule->command('log:sonnenertrag')
				 ->dailyAt('23:55')
		 		 ->when(function()
						{
							return env('SCHEDULE_SONNENERTRAG');
						});

	}

}
