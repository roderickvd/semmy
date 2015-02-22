<?php namespace App\Contracts;

interface HTTP {
	
	/*
	|--------------------------------------------------------------------------
	| HTTP Contract
	|--------------------------------------------------------------------------
	|
	| This contract specifies which methods a HTTP adapter must implement.
	| The adapter must save cookie sessions and set them in the next
	| request for the same host.
	|
	*/

	/**
	 * Retrieve a HTTP resource.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @return string
	 */
	public static function get($host, $uri);
	
	/**
	 * Create a HTTP resource.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @param  string  $data
	 * @param  array   $headers
	 * @return string
	 */
	public static function post($host, $uri, $data, $headers);

}

?>
