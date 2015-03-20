<?php namespace Responses\WeatherStations;

use App\Contracts\HTTP as HTTPContract;

class KNMIResponse implements HTTPContract {

    /*
	|--------------------------------------------------------------------------
    | Mock OpenWeatherMap HTTP Response
    |--------------------------------------------------------------------------
    |
    | This mock returns a real-world OpenWeatherMap response.
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
		return file_get_contents(__DIR__.'/HTML/KNMI.html');
    }

	public static function post($host, $uri, $data, $headers = [])
	{
		//
	}

}

?>
