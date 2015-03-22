<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WeatherStationServiceProvider extends ServiceProvider {

	/*
	 * The environment variable for the inverter driver.
	 *
	 * @const string
	 */
	const DRIVER_VAR = 'WEATHER_DRIVER';

	/**
	 * The default driver.
	 *
	 * @const string
	 */
	const DEFAULT_DRIVER = 'null';

	/**
	 * The supported weather station drivers.
	 *
	 * @const array
	 */

	// Array constants are not supported before PHP 5.6.
	protected static $DRIVERS = [
		'Null'				 => 'null',
		'KNMI'               => 'knmi',
		'OpenWeatherMap'     => 'openweathermap',
		'WeatherUnderground' => 'weatherunderground'
	];

	/**
	 * Indicates that the loading of this provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap any weather services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any weather services.
	 *
	 * @return void
	 */
	public function register()
	{
		$driver = array_search(env(self::DRIVER_VAR, self::DEFAULT_DRIVER), self::$DRIVERS);
		$this->app->singleton('App\Contracts\WeatherStation', 'App\Services\WeatherStations\\'.$driver.'Service');
	}

	/**
	 * Get the services provided by this provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['App\Contracts\WeatherStation'];
	}

}
