<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * The configured inverter.
	 *
	 * @var App\Contracts\Inverter
	 */
	protected $inverter;

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

	/**
	 * Set up a particular inverter adapter.
	 *
	 * @param string  $mock
	 * @return void
	 */
	protected function setInverter($mock)
	{
        $this->app->singleton('App\Contracts\Inverter', 'App\Services\Inverters\\'.$mock);
        $this->inverter = $this->app->make('App\Contracts\Inverter');		
	}

	/**
	 * Set up a particular inverter response.
	 *
	 * @param string  $namespace
	 * @param string  $mock
	 * @return void
	 */
	protected function setResponse($mock)
	{
		$file = str_replace('\\', '/', $mock);
		require_once __DIR__."/Mocks/Responses/{$file}.php";
		$this->app->singleton('App\Contracts\HTTP', 'Responses\\'.$mock);
	}

	protected function setInverterAndResponse($inverter, $response)
	{
		$this->setResponse('Inverters\\'.$inverter.'\\'.$response);
		$this->setInverter($inverter);
	}

	/**
	 * Set up the dummy inverter by default.
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		Dotenv::makeMutable();

		// FIXME - why is WEATHER_LOCATION pulled from the actual .env file
		// instead of phpunit.xml?
		Dotenv::setEnvironmentVariable('WEATHER_LOCATION', 'Den Helder');

		require_once __DIR__.'/Mocks/Inverters/DummyInverter.php';
		$this->setInverter('DummyInverter');

		Artisan::call('httpcache:clear');
	}

}
