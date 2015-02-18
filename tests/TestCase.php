<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	const SUPPORTED_INVERTERS = [
		'StecaGrid'
	];

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
	protected function setResponse($namespace, $mock)
	{
		if ($namespace) {
			require_once __DIR__."/Mocks/Responses/{$namespace}/{$mock}.php";
			$this->app->singleton('HTTP', 'Responses\\'.$namespace.'\\'.$mock);

		} else {
			require_once __DIR__."/Mocks/Responses/{$mock}.php";
			$this->app->singleton('HTTP', 'Responses\\'.$mock);

		}

	}

	/**
	 * Set up the dummy inverter by default.
	 *
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();

		require_once __DIR__.'/Mocks/Inverters/DummyInverter.php';
		$this->setInverter('DummyInverter');
	}

}
