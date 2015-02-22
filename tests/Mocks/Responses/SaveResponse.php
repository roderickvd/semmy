<?php namespace Responses;

use App\Contracts\HTTP as HTTPContract;

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
	 * @return string
	 */
    public static function get($host, $uri)
    {
		//
    }

	public static function post($host, $uri, $data, $headers)
	{
		self::$data    = http_build_query($data);
		self::$headers = $headers;

		// Most callers do not care, except for the SonnenertragLogger.
		return 'true';
	}

}

?>
