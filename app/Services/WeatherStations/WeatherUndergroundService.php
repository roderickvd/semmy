<?php namespace App\Services\WeatherStations;

use App\Contracts\HTTP;
use App\Contracts\WeatherStation as WeatherStationContract;

use Log;

class WeatherUndergroundService implements WeatherStationContract {

	/*
	|--------------------------------------------------------------------------
	| OpenWeatherMap
	|--------------------------------------------------------------------------
	|
	| This weather adapter returns weather conditions from Weather Underground.
	|
	*/

	/**
	 * The Weather Underground host.
	 *
	 * @const string
	 */
	const HOST = 'http://api.wunderground.com';

	/**
	 * The URI to the weather API.
	 *
	 * @const string
	 */
	const WEATHER_URI = '/api';

	/**
	 * The minimum interval before refreshing the weather.
	 *
	 * @const int
	 */
	const UPDATE_INTERVAL = 180;  // seconds

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
	 * The weather station location.
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

		$this->api_key  = env('WEATHER_API_KEY');
		$this->location = str_replace(' ', '_', env('WEATHER_LOCATION'));

		if (!$this->is_configured()) {
			Log::error('No location set for Weather Underground.');

		}

		if (!$this->api_key) {
			Log::error('No API key set for Weather Underground.');

		}
	}

	/**
	 * Check if the adapter is fully configured.
	 *
	 * @return boolean
	 */
	protected function is_configured()
	{
		if ($this->location && $this->api_key) {
			return true;
		}

		return false;
	}

	/**
	 * Update the current weather conditions.
	 *
	 * @return void
	 */
	protected function update_weather()
	{
		if ($this->is_configured()) {

			$uri = self::WEATHER_URI.'/'.$this->api_key.'/conditions/q/'.$this->location.'.json';
			$response = $this->http->get(self::HOST, $uri);

			// this returns null on an invalid response
			$weather = json_decode($response);

			$temperature = null;
			if ($weather && property_exists($weather, 'current_observation') && property_exists($weather->current_observation, 'temp_c')) {
				$temperature = $weather->current_observation->temp_c;

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

	/**
	 * Get the minimum interval in seconds before refreshing the measurements.
	 *
	 * @return int
	 */
	public function update_interval()
	{
		return self::UPDATE_INTERVAL;
	}

}

?>
