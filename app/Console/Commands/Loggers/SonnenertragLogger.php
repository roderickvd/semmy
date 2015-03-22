<?php namespace App\Console\Commands\Loggers;

use App\Contracts\HTTP;
use App\Contracts\Inverter;
use Dotenv;

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
	const HOST = 'http://www.sonnenertrag.eu';

	/**
	 * The URI to the Sonnenertrag login form handler.
	 *
	 * @const string
	 */
	const LOGIN_URI = '/ajax/user/login';

	/**
	 * The URI to the Sonnenertrag daily data form handler.
	 *
	 * @const string
	 */
	const DAILY_URI = '/plant/insertdatadaily';

	/*
	 * The environment variable for the system ID.
	 *
	 * @const string
	 */
	const PB_VAR = 'SONNENERTRAG_PB_ID';

	/*
	 * The environment variable for the username.
	 *
	 * @const string
	 */
	const USERNAME_VAR = 'SONNENERTRAG_USERNAME';

	/*
	 * The environment variable for the password.
	 *
	 * @const string
	 */
	const PASSWORD_VAR = 'SONNENERTRAG_PASSWORD';

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

		Dotenv::required(array(self::PB_VAR, self::USERNAME_VAR, self::PASSWORD_VAR));

		$this->pb_id    = env(self::PB_VAR);
		$this->username = env(self::USERNAME_VAR);
		$this->password = env(self::PASSWORD_VAR);
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

		if ($this->http->post(self::HOST, self::LOGIN_URI, $login, []) === 'true')
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
		if ($this->login()) {

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

			$this->http->post(self::HOST, self::DAILY_URI, $daily_data, []);

		}
	}

	/**
	 * Update PVOutput with today's generation.
	 *
	 * @return void
	 */
	public function update()
	{
		$timestamp  = time();
		$generation = $this->inverter->generation();
		$this->update_with($timestamp, $generation);
	}

}

?>
