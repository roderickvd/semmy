<?php namespace App\Console\Commands;

use App;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LogPVOutput extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'log:pvoutput';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update PVOutput with the instantaneous measurements';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		App::make('App\Console\Commands\Loggers\PVOutputLogger')->update();
	}

}
