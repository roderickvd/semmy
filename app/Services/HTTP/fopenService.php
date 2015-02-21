<?php namespace App\Services\HTTP;

use App\Contracts\HTTP as HTTPContract;

class fopenService implements HTTPContract {

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
	 * Builds a header string for the stream context.
	 *
	 * @param  array  $headers
	 * @return string
	 */
	protected static function build_headers($headers)
	{
		$header_string = '';
		foreach ($headers as $header) {
			$header_string = $header_string . $header . "\r\n";
		}

		return $header_string;
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
		$content = http_build_query($data);

		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		$headers[] = "Content-Length: " . strlen($content);

		$options = [
		    'http' => [
		        'method'  => 'POST',
		        'header'  => self::build_headers($headers),
		        'content' => $content,
			]
		];

		$context  = stream_context_create($options);
		return file_get_contents($url, false, $context);
	}

}
