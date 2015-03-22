<?php namespace App\Console\Commands\Loggers;

use App\Contracts\HTTP;
use App\Contracts\Inverter;
use App\Contracts\WeatherStation;
use Dotenv;

class PVOutputLogger {
	
	/*
	|--------------------------------------------------------------------------
	| PVOutput Logger
	|--------------------------------------------------------------------------
	|
	| Sends inverter measurements to the PVOutput API.
	|
	*/

	/**
	 * The PVOutput host.
	 *
	 * @const string
	 */
	const HOST = 'http://pvoutput.org';

	/**
	 * The URI to the PVOutput Status Service.
	 *
	 * @const string
	 */
	const STATUS_URI = '/service/r2/addstatus.jsp';

	/*
	 * The environment variable for the system ID.
	 *
	 * @const string
	 */
	const SID_VAR = 'PVOUTPUT_SID';

	/*
	 * The environment variable for the API key.
	 *
	 * @const string
	 */
	const API_KEY_VAR = 'PVOUTPUT_API_KEY';

	/**
	 * The HTTP service.
	 *
	 * @var App\Contracts\HTTP
	 */
	protected $http;

	/**
	 * The weather station.
	 *
	 * @var App\Contracts\WeatherStation
	 */
	protected $weather_station;

	/**
	 * The inverter.
	 *
	 * @var App\Contracts\Inverter
	 */
	protected $inverter;

	/**
	 * The PVOutput system ID.
	 *
	 * @var int
	 */
	protected $sid;

	/**
	 * The PVOutput API key.
	 *
	 * @var string
	 */
	protected $api_key;

	/**
	 * Create a new PVOutput Logger instance.
	 *
	 * @param  App\Contracts\HTTP      $http;
	 * @param  App\Contracts\Inverter  $inverter;
	 * @return void
	 */
	public function __construct(HTTP $http, Inverter $inverter, WeatherStation $weather_station)
	{
		$this->http            = $http;
		$this->inverter        = $inverter;
		$this->weather_station = $weather_station;

		Dotenv::required(array(self::SID_VAR, self::API_KEY_VAR));

		$this->sid     = env(self::SID_VAR);
		$this->api_key = env(self::API_KEY_VAR);
	}

	/**
	 * Update PVOutput with a given set of measurements at a certain time.
	 *
	 * @param  int  $timestamp
	 * @param  int  $generation
	 * @param  int  $ac_power
	 * @param  int  $dc_voltage
	 * @return void
	 */
	public function update_with($timestamp, $generation, $ac_power, $dc_voltage)
	{
		$headers = [
			"X-Pvoutput-Apikey: {$this->api_key}",
			"X-Pvoutput-SystemId: {$this->sid}"
		];

		$status = [
			'd'  => date('Ymd', $timestamp),
			't'  => date('H:i', $timestamp),
			'v1' => $generation,
			'v2' => $ac_power,
			'v6' => $dc_voltage
		];

		if ($this->weather_station) {
			$status = $status + [
				'v5' => $this->weather_station->temperature()
			];

		}

		$this->http->post(self::HOST, self::STATUS_URI, $status, $headers);
	}

	/**
	 * Update PVOutput with the current measurements.
	 *
	 * @return void
	 */
	public function update()
	{
		$measurements = $this->inverter->measurements();
		$timestamp = time();

		$generation = $measurements['generation'];
		$ac_power   = $measurements['ac_power'];
		$dc_voltage = $measurements['dc_voltage'];

		$this->update_with($timestamp, $generation, $ac_power, $dc_voltage);
	}

}

?>
