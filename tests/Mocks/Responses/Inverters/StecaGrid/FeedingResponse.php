<?php namespace Responses\Inverters\StecaGrid;

use App\Contracts\HTTP as HTTPContract;

class FeedingResponse implements HTTPContract {

    /*
	|--------------------------------------------------------------------------
    | Mock Feeding StecaGrid HTTP Response
    |--------------------------------------------------------------------------
    |
    | This mock returns a real-world response that a StecaGrid inverter may
    | send when feeding.
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
		if (strpos($uri, 'gen.yield.day.chart.js') === false) {
			return file_get_contents(__DIR__.'/JavaScript/feeding.js');

		} else {
			return file_get_contents(__DIR__.'/JavaScript/3900.js');

		}
    }

	public static function post($host, $uri, $data, $headers = [])
	{
		//
	}

}

?>
