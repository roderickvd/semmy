<?php namespace App\Services\HTTP;

use App\Contracts\HTTP as HTTPContract;

class cURLService implements HTTPContract {

	/*
	|--------------------------------------------------------------------------
	| fopen wrappers HTTP Service
	|--------------------------------------------------------------------------
	|
	| This service accesses HTTP resources using fopen wrappers.
	| Access it through the HTTP facade.
	|
	*/

	/**
	 * Retrieve a HTTP resource.
	 *
	 * @param  string  $url
	 * @return string
	 */
	public static function get($url)
	{
		return file_get_contents($url);
	}

	/**
	 * Create a HTTP resource.
	 *
	 * @param  string  $url
	 * @param  string  $data
	 * @return string
	 */
	public static function post($url, $data)
	{
		$content = http_build_query($data);
		$options = [
		    'http' => [
		        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n" .
							 "Content-Length: " . strlen($data) . "\r\n",
		        'method'  => 'POST',
		        'content' => http_build_query($content),
			]
		];

		$context  = stream_context_create($options);
		return file_get_contents($url, false, $context);
	}

}
