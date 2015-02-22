<?php namespace Responses;

use App\Console\Commands\Loggers\SonnenertragLogger;
use App\Contracts\HTTP as HTTPContract;
use App\Services\WeatherStations\OpenWeatherMapService;

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
	 * An actual OpenWeatherMap resonse for Amsterdam, the Netherlands.
	 *
	 * @const string
	 */
	const OPENWEATHERMAP_RESPONSE = '{"coord":{"lon":4.89,"lat":52.37},"sys":{"type":3,"id":51677,"message":0.1728,"country":"NL","sunrise":1424587268,"sunset":1424624798},"weather":[{"id":501,"main":"Rain","description":"moderate rain","icon":"10n"}],"base":"cmc stations","main":{"temp":276.77,"humidity":81,"pressure":1000.127,"temp_min":273.15,"temp_max":278.75},"wind":{"speed":5.2,"gust":10.5,"deg":177},"rain":{"1h":2.7},"clouds":{"all":92},"dt":1424636106,"id":2759794,"name":"Amsterdam","cod":200}';

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
			return self::OPENWEATHERMAP_RESPONSE;

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
