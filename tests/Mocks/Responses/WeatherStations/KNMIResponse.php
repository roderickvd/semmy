<?php namespace Responses\WeatherStations;

use App\Contracts\HTTP as HTTPContract;

class KNMIResponse implements HTTPContract {

    /*
	|--------------------------------------------------------------------------
    | Mock KNMI HTTP Response
    |--------------------------------------------------------------------------
    |
    | This mock returns a real-world KNMI page.
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
		return file_get_contents(__DIR__.'/html/knmi.html');
    }

	public static function post($host, $uri, $data, $headers = [])
	{
		//
	}

}

?>
