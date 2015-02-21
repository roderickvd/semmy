<?php namespace Responses;

use App\Contracts\HTTP as HTTPContract;

class OfflineResponse implements HTTPContract {

    /*
	|--------------------------------------------------------------------------
    | Mock Offline HTTP Response
    |--------------------------------------------------------------------------
    |
    | This mock returns a null response when an inverter is standby.
    |
    */

	/**
	 * Return a null response.
	 *
	 * @param  string  $uri
	 * @return void
	 */
    public static function get($url)
    {
        return;
    }

	public static function post($url, $data, $headers)
	{
		//
	}

}

?>
