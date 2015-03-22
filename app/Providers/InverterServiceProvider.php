<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dotenv;

class InverterServiceProvider extends ServiceProvider {

	/*
	 * The environment variable for the inverter driver.
	 *
	 * @const string
	 */
	const DRIVER_VAR = 'INV_DRIVER';

	/**
	 * The supported inverter drivers.
	 *
	 * @const array
	 */

	// Array constants are not supported before PHP 5.6.
	protected static $DRIVERS = [
		'StecaGrid' => 'stecagrid'
	];

	/**
	 * Bootstrap any inverter services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any inverter services.
	 *
	 * @return void
	 */
	public function register()
	{
		Dotenv::required(self::DRIVER_VAR, array_values(self::$DRIVERS));
		$driver = array_search(env(self::DRIVER_VAR), self::$DRIVERS);
		$this->app->singleton('App\Contracts\Inverter', 'App\Services\Inverters\\'.$driver);
	}

}
