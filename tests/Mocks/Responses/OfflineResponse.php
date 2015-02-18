<?php namespace Responses;

class OfflineResponse {

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
    public function get($url)
    {
        return;
    }

}

?>
