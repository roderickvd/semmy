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
	 * Download an inverter resource.
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
