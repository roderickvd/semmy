<?php namespace App\Services\WeatherStations;

use App\Contracts\HTTP;
use App\Contracts\WeatherStation as WeatherStationContract;

use Log;

class OpenWeatherMapService implements WeatherStationContract {

	/*
	|--------------------------------------------------------------------------
	| OpenWeatherMap
	|--------------------------------------------------------------------------
	|
	| This weather adapter returns weather from OpenWeatherMap.
	|
	*/

	/**
	 * The OpenWeatherMap host.
	 *
	 * @const string
	 */
	const OPENWEATHERMAP_HOST = 'http://openweathermap.org';

	/**
	 * The URI to the weather API.
	 *
	 * @const string
	 */
	const WEATHER_URI = '/data/2.5/weather';

	/**
	 * The minimum interval before refreshing the weather.
	 *
	 * @const int
	 */
	const UPDATE_INTERVAL = 600;  // seconds

	/**
	 * The timestamp of the last weather update.
	 *
	 * @var int
	 */
	protected $last_updated_at = 0;

	/**
	 * The OpenWeatherMap API key.
	 *
	 * @var string
	 */
	protected $api_key;

	/**
	 * The OpenWeatherMap location.
	 *
	 * @var string
	 */
	protected $location;

	/**
	 * The latest temperature.
	 *
	 * @var array
	 */
	protected $temperature;

	/**
	 * The HTTP service.
	 *
	 * @var App\Contracts\HTTP
	 */
	protected $http;

	/**
	 * Create a new OpenWeatherMap instance.
	 *
	 * @param  App\Contracts\HTTP  $http
	 * @return void
	 */
	public function __construct(HTTP $http)
	{
		$this->http = $http;

		$this->api_key  = env('OPENWEATHERMAP_API_KEY');
		$this->location = env('OPENWEATHERMAP_LOCATION');

		if (!$this->is_configured()) {
			Log::error('No location set for OpenWeatherMap.');

		}

		// Queries without an API key *may* work.
		if (!$this->api_key) {
			Log::warning('No API key set for OpenWeatherMap.');

		}
	}

	/**
	 * Check if OpenWeatherMap is fully configured.
	 *
	 * @return boolean
	 */
	protected function is_configured()
	{
		if ($this->location) {
			return true;
		}

		return false;
	}

	/**
	 * Update the inverter measurements.
	 *
	 * @return void
	 */
	protected function update_weather()
	{
		if ($this->is_configured()) {

			$header = ["x-api-key:{$this->api_key}"];
			$uri = self::WEATHER_URI.'?'.http_build_query(['q' => $this->location]);
			$response = $this->http->get(self::OPENWEATHERMAP_HOST, $uri, $header);

			$weather = json_decode($response);

			$temperature = null;
			if (property_exists($weather, 'main') && property_exists($weather->main, 'temp')) {
				$temperature = $weather->main->temp - 273.15;  // Kelvin to Celcius

			}

			$this->temperature = $temperature;
		}
	}

	/**
	 * Get and memoize the current temperature in degrees Celcius.
	 *
	 * @return float
	 */
	public function temperature()
	{
		$timestamp = time();
		if ($timestamp - $this->last_updated_at > self::UPDATE_INTERVAL) {
			$this->update_weather();
			$this->last_updated_at = $timestamp;
		}

		return $this->temperature;
	}

}

?>
