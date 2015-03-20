<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WeatherStationServiceProvider extends ServiceProvider {

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
		switch (env('WEATHER_DRIVER')) {
			case 'knmi':
				$driver = 'KNMI';
				break;

			case 'openweathermap':
				$driver = 'OpenWeatherMap';
				break;

			case 'weatherunderground':
				$driver = 'WeatherUnderground';
				break;

			default:
				$driver = 'Null';
				break;

		}

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
