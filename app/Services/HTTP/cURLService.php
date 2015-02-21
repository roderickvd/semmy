<?php namespace App\Services\HTTP;

use App\Contracts\HTTP as HTTPContract;

class cURLService implements HTTPContract {

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
	 * Retrieve a HTTP resource.
	 *
	 * @param  string  $url
	 * @return string
	 */
	public static function get($url)
	{
		$session = curl_init($url);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);

		curl_close($session);
		return $response;
	}

	/**
	 * Create a HTTP resource.
	 *
	 * @param  string  $url
	 * @param  string  $data
	 * @param  array   $headers
	 * @return string
	 */
	public static function post($url, $data, $headers)
	{
		$session = curl_init($url);
		$content = http_build_query($data);

		curl_setopt($session, CURLOPT_HTTPHEADER,     $headers);
		curl_setopt($session, CURLOPT_POST,           TRUE);
		curl_setopt($session, CURLOPT_POSTFIELDS,     $content);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($session);

		curl_close($session);
		return $response;
	}

}

?>
