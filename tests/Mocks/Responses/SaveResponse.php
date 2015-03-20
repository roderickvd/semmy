<?php namespace Responses;

use App\Console\Commands\Loggers\SonnenertragLogger;
use App\Contracts\HTTP as HTTPContract;
use App\Services\WeatherStations\OpenWeatherMapService;
use Responses\WeatherStations\OpenWeatherMapResponse;

class SaveResponse implements HTTPContract {

    /*
	|--------------------------------------------------------------------------
    | HTTP Response Saver
    |--------------------------------------------------------------------------
    |
    | This mock saves Semmy's HTTP requests, so that they can be compared
	| to a known string.
    |
    */

	/**
	 * The previously sent data.
	 *
	 * @var string
	 */
    public static $data;

	/**
	 * The previously sent headers.
	 *
	 * @var string
	 */
    public static $headers;

	/**
	 * Return the sample response.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @param  array   $headers
	 * @return string
	 */
    public static function get($host, $uri, $headers = [])
    {
		if ($host == OpenWeatherMapService::OPENWEATHERMAP_HOST) {
			require_once __DIR__.'/WeatherStations/OpenWeatherMapResponse.php';
			return OpenWeatherMapResponse::get($host, $uri, $headers);

		}
    }

	public static function post($host, $uri, $data, $headers = [])
	{
		self::$data    = http_build_query($data);
		self::$headers = $headers;

		if ($host == SonnenertragLogger::SONNENERTRAG_HOST) {
			return 'true';

		}
	}

}

?>
