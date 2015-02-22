<?php namespace App\Services\HTTP;

use App\Contracts\HTTP as HTTPContract;

class fopenService extends HTTPCookieService implements HTTPContract {

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
	 * Access a HTTP resource.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @param  array   $options
	 * @param  array   $headers
	 * @return string
	 */
	protected static function access($host, $uri, $options, $headers)
	{
		$options['http']['header'] = implode("\r\n", self::add_cookies($headers));

		$context  = stream_context_create($options);
		$response = file_get_contents(self::init_url($host, $uri), false, $context);

		foreach ($http_response_header as $header_line) {
			self::save_cookies($context, $header_line);
		}

		return $response;
	}

	/**
	 * Retrieve a HTTP resource.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @param  array   $headers
	 * @return string
	 */
	public static function get($host, $uri, $headers = [])
	{
		return self::access($host, $uri, [], $headers);
	}

	/**
	 * Create a HTTP resource.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @param  string  $data
	 * @param  array   $headers
	 * @return string
	 */
	public static function post($host, $uri, $data, $headers = [])
	{
		$content = http_build_query($data);

		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		$headers[] = "Content-Length: " . strlen($content);

		$options = [
		    'http' => [
		        'method'  => 'POST',
		        'content' => $content,
			]
		];

		return self::access($host, $uri, $options, $headers);
	}

}
