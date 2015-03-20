<?php namespace Responses\Inverters\StecaGrid;

use App\Contracts\HTTP as HTTPContract;

class StandbyResponse implements HTTPContract {

    /*
	|--------------------------------------------------------------------------
    | Mock Standby StecaGrid HTTP Response
    |--------------------------------------------------------------------------
    |
    | This mock returns a real-world response that a StecaGrid inverter may
    | send when on standby.
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
			return file_get_contents(__DIR__.'/JavaScript/standby.js');

		} else {
			return file_get_contents(__DIR__.'/JavaScript/900.js');

		}
    }

	public static function post($host, $uri, $data, $headers = [])
	{
		//
	}

}

?>
