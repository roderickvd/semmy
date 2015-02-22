<?php namespace App\Console\Commands;

use App;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Update extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'loggers:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update the loggers with the instantaneous measurements';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$pvoutput     = App::make('App\Console\Commands\Loggers\PVOutputLogger');
		$sonnenertrag = App::make('App\Console\Commands\Loggers\SonnenertragLogger');

		$pvoutput->update();
		$sonnenertrag->update();
	}

}
