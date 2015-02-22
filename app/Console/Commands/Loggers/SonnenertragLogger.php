<?php namespace App\Console\Commands\Loggers;

use App\Contracts\HTTP;
use App\Contracts\Inverter;

class SonnenertragLogger {
	
	/*
	|--------------------------------------------------------------------------
	| Sonnenertrag Logger
	|--------------------------------------------------------------------------
	|
	| Sends inverter measurements to the Sonnenertrag API. Sonnenertrag is
	| also known as Solar-yield or Zonnestroomopbrengst.
	|
	*/

	/**
	 * The Sonnenertrag host.
	 *
	 * @const string
	 */
	const SONNENERTRAG_HOST = 'http://www.sonnenertrag.eu';

	/**
	 * The URI to the Sonnenertrag login form handler.
	 *
	 * @const string
	 */
	const SONNENERTRAG_LOGIN_URI = '/ajax/user/login';

	/**
	 * The URI to the Sonnenertrag daily data form handler.
	 *
	 * @const string
	 */
	const SONNENERTRAG_DAILY_URI = '/plant/insertdatadaily';

	/**
	 * The HTTP service.
	 *
	 * @var App\Contracts\HTTP
	 */
	protected $http;

	/**
	 * The inverter.
	 *
	 * @var App\Contracts\Inverter
	 */
	protected $inverter;

	/**
	 * The Sonnenertrag facility ID.
	 *
	 * @var int
	 */
	protected $pb_id;

	/**
	 * The Sonnenertrag username.
	 *
	 * @var string
	 */
	protected $username;

	/**
	 * The Sonnenertrag password.
	 *
	 * @var string
	 */
	protected $password;

	/**
	 * Create a new Sonnenertrag Logger instance.
	 *
	 * @param  App\Contracts\HTTP      $http;
	 * @param  App\Contracts\Inverter  $inverter;
	 * @return void
	 */
	public function __construct(HTTP $http, Inverter $inverter)
	{
		$this->http     = $http;
		$this->inverter = $inverter;

		$this->pb_id    = env('SONNENERTRAG_PB_ID');
		$this->username = env('SONNENERTRAG_USERNAME');
		$this->password = env('SONNENERTRAG_PASSWORD');

		if (!$this->is_configured()) {
			abort(500, 'Sonnenertrag configuration incomplete.');

		}
	}

	/**
	 * Check if Sonnenertrag is fully configured.
	 *
	 * @return boolean
	 */
	protected function is_configured()
	{
		if ($this->pb_id && $this->username && $this->password) {
			return true;
		}

		return false;
	}

	/**
	 * Login to Sonnenertrag. The session cookie is stored
	 * transparently by the HTTP service provider.
	 *
	 * @return boolean
	 */
	protected function login()
	{
		$login = [
			'user'     => $this->username,
			'password' => $this->password,

			'submit' => 'Login'
		];

		if ($this->http->post(self::SONNENERTRAG_HOST, self::SONNENERTRAG_LOGIN_URI, $login, []) === 'true')
		{
			return true;

		}

		return false;
	}

	/**
	 * Update Sonnenertrag with a given set of measurements at a certain date.
	 *
	 * @param  string  $date
	 * @param  int     $generation
	 * @return void
	 */
	public function update_with($timestamp, $generation)
	{
		if ($this->is_configured() && $this->login()) {

			$date  = date('Y-m-d', $timestamp);
			$year  = date('Y', $timestamp);
			$month = date('n', $timestamp);

			$daily_data = [
				'order' => null,
				'pb_id' => $this->pb_id,

				'month' => $month,
				'year'  => $year,

				"yield[{$date}]"          => $generation / 1000,
				"is_auto_update[{$date}]" => 1,

				'save' => 'Save'			
			];

			$this->http->post(self::SONNENERTRAG_HOST, self::SONNENERTRAG_DAILY_URI, $daily_data, []);

		}
	}

	/**
	 * Update PVOutput with today's generation.
	 *
	 * @return void
	 */
	public function update()
	{
		if ($this->is_configured()) {
			$timestamp  = time();
			$generation = $this->inverter->generation();

			$this->update_with($timestamp, $generation);

		}
	}

}

?>
