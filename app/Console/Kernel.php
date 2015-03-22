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
		if (env('SCHEDULE_PVOUTPUT') == 'true') {
			$schedule->command('log:pvoutput')
					 ->everyFiveMinutes();

		}

		if (env('SCHEDULE_SONNENERTRAG') == 'true') {
			$schedule->command('log:sonnenertrag')
					 ->dailyAt('23:55');

		}
	}

}
