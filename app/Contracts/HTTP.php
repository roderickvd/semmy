<?php namespace App\Contracts;

interface HTTP {
	
	/*
	|--------------------------------------------------------------------------
	| HTTP Contract
	|--------------------------------------------------------------------------
	|
	| This contract specifies which methods a HTTP adapter must implement.
	|
	*/

	/**
	 * Retrieve a HTTP resource.
	 *
	 * @param  string  $url
	 * @return string
	 */
	public static function get($url);
	
	/**
	 * Create a HTTP resource.
	 *
	 * @param  string  $url
	 * @param  string  $data
	 * @return string
	 */
	public static function post($url, $data);

}

?>
