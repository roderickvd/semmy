<?php namespace App\Services\WeatherStations;

use App\Contracts\HTTP;
use App\Contracts\WeatherStation as WeatherStationContract;
use DOMDocument;
use Log;

class KNMIService implements WeatherStationContract {

	/*
	|--------------------------------------------------------------------------
	| KNMI Weather Station
	|--------------------------------------------------------------------------
	|
	| This weather adapter returns weather conditions from KNMI.
	|
	*/

	/**
	 * The KNMI host.
	 *
	 * @const string
	 */
	const KNMI_HOST = 'http://www.knmi.nl';

	/**
	 * The URI to the weather page.
	 *
	 * @const string
	 */
	const WEATHER_URI = '/actueel/';

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
	 * Create a new KNMI instance.
	 *
	 * @param  App\Contracts\HTTP  $http
	 * @return void
	 */
	public function __construct(HTTP $http)
	{
		$this->http = $http;
		$this->location = env('WEATHER_LOCATION');

		if (!$this->is_configured()) {
			Log::error('No KNMI weather station set.');

		}

		// Suppress errors regarding malformed HTML.
		libxml_use_internal_errors(true);
	}

	/**
	 * Check if the adapter is fully configured.
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
	 * Update the current weather conditions.
	 *
	 * @return void
	 */
	protected function update_weather()
	{
		if ($this->is_configured()) {

			$response = $this->http->get(self::KNMI_HOST, self::WEATHER_URI);

			$temperature = null;
			if ($response) {
				$dom = new DOMDocument();
				$dom->loadHTML($response);
				$elements = $dom->getElementsByTagName('td');

				for ($i = 0; $i < $elements->length; $i++) {
					if ($elements->item($i)->nodeValue == $this->location) {
						$temperature = floatval($elements->item($i+2)->nodeValue);
						break;
					}

				}
			}

			if ($temperature) {
				$this->temperature = $temperature;

			} else {
				Log::error("KNMI weather station \"{$this->location}\" was not found.");

			}
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
		return UPDATE_INTERVAL;
	}

}

?>
