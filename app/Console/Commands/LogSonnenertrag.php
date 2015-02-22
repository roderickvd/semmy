<?php namespace App\Console\Commands;

use App;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LogSonnenertrag extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'log:sonnenertrag';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Update Sonnenertrag with today's measurements";

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		App::make('App\Console\Commands\Loggers\SonnenertragLogger')->update();
	}

}
