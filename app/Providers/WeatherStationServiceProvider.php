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
		$this->app->singleton('App\Contracts\WeatherStation', 'App\Services\WeatherStations\OpenWeatherMapService');
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
