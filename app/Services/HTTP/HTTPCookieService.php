<?php namespace App\Services\HTTP;

abstract class HTTPCookieService {

	/*
	|--------------------------------------------------------------------------
	| HTTP Cookie Service
	|--------------------------------------------------------------------------
	|
	| This abstract service implements cookie handling.
	| Extend it in implementations of the HTTP contract.
	|
	*/

	/**
	 * The cookies received in the last request.
	 *
	 * @var string
	 */
	protected static $cookies;

	/**
	 * The host accessed in the last request.
	 *
	 * @var string
	 */
	protected static $cookie_host;

	/**
	 * Build a URL for a given host and URI, flushing any cookies if necessary.
	 *
	 * @param  string  $host
	 * @param  string  $uri
	 * @return string
	 */
	protected static function init_url($host, $uri)
	{
		if ($host != self::$cookie_host) {
			self::$cookie_host = $host;
			self::$cookies     = null;

		}

		return $host . $uri;
	}

	/**
	 * Save any cookies and return the header line length.
	 *
	 * @param  mixed  $resource
	 * @param  string $header_line
	 * @return int
	 */
	protected static function save_cookies($resource, $header_line)
	{
		if (preg_match('@Set-Cookie: (([^=]+)=[^;]+)@i', $header_line, $matches)) {
			$match = $matches[1];

			if (self::$cookies) {
				self::$cookies = self::$cookies . ';' . $match;

			} else {
				self::$cookies = $match;

			}

		}

		// By cURL contract, this method must return the header line length.
		return strlen($header_line);
	}

	/**
	 * Add any cookies to a set of headers.
	 *
	 * @param  array  $headers
	 * @return array
	 */
	protected static function add_cookies($headers)
	{
		if (self::$cookies) {
			$headers[] = 'Cookie: ' . self::$cookies;

		}

		return $headers;
	}

}

?>
