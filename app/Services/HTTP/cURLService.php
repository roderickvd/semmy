<?php namespace App\Services\HTTP;

use App\Contracts\HTTP as HTTPContract;

class cURLService extends HTTPCookieService implements HTTPContract {

	/*
	|--------------------------------------------------------------------------
	| cURL HTTP Service
	|--------------------------------------------------------------------------
	|
	| This service accesses HTTP resources using the cURL library.
	| Access it through the HTTP facade.
	|
	*/

	/**
	 * The default cURL options.
	 *
	 * @const array
	 */

	// Array constants are not supported before PHP 5.6.
	protected static $default_curlopts = [
		CURLOPT_HEADERFUNCTION => __CLASS__.'::save_cookies',
		CURLOPT_RETURNTRANSFER => TRUE
	];

	/**
	 * Access a HTTP resource.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @param  array   $options
	 * @return string
	 */
	protected static function access($host, $uri, $options)
	{
		$session = curl_init(self::init_url($host, $uri));
		curl_setopt_array($session, self::$default_curlopts + $options);

		$response = curl_exec($session);
		curl_close($session);

		return $response;
	}

	/**
	 * Retrieve a HTTP resource.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @return string
	 */
	public static function get($host, $uri)
	{
		$options = [
			CURLOPT_HTTPHEADER => self::add_cookies([])
		];

		return self::access($host, $uri, $options);
	}

	/**
	 * Create a HTTP resource.
	 *
	 * @param  string  $url
	 * @param  string  $data
	 * @param  array   $headers
	 * @return string
	 */
	public static function post($host, $uri, $data, $headers)
	{
		$content = http_build_query($data);
		$options = [
			CURLOPT_HTTPHEADER => self::add_cookies($headers),
			CURLOPT_POST       => TRUE,
			CURLOPT_POSTFIELDS => $content
		];

		return self::access($host, $uri, $options);
	}

}

?>
