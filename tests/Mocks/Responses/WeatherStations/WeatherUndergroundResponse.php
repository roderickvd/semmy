<?php namespace Responses\WeatherStations;

use App\Contracts\HTTP as HTTPContract;

class WeatherUndergroundResponse implements HTTPContract {

    /*
	|--------------------------------------------------------------------------
    | Mock Weather Underground HTTP Response
    |--------------------------------------------------------------------------
    |
    | This mock returns a real-world Weather Underground response.
    |
    */

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
		return file_get_contents(__DIR__.'/JSON/WeatherUnderground.json');
    }

	public static function post($host, $uri, $data, $headers = [])
	{
		//
	}

}

?>
