<?php namespace App\Console\Commands\Loggers;

use App\Contracts\HTTP;
use App\Contracts\Inverter;
use App\Contracts\WeatherStation;

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
	const PVOUTPUT_HOST = 'http://pvoutput.org';

	/**
	 * The URI to the PVOutput Status Service.
	 *
	 * @const string
	 */
	const STATUS_URI = '/service/r2/addstatus.jsp';

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

		$this->sid     = env('PVOUTPUT_SID');
		$this->api_key = env('PVOUTPUT_API_KEY');

		if (!$this->is_configured()) {
			abort(500, 'PVOutput configuration incomplete.');

		}
			
	}

	/**
	 * Check if PVOutput is fully configured.
	 *
	 * @return boolean
	 */
	protected function is_configured()
	{
		if ($this->sid && $this->api_key) {
			return true;
		}

		return false;
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
		if ($this->is_configured()) {

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

			$this->http->post(self::PVOUTPUT_HOST, self::STATUS_URI, $status, $headers);

		}
	}

	/**
	 * Update PVOutput with the current measurements.
	 *
	 * @return void
	 */
	public function update()
	{
		if ($this->is_configured()) {

			$measurements = $this->inverter->measurements();
			$timestamp = time();

			$generation = $measurements['generation'];
			$ac_power   = $measurements['ac_power'];
			$dc_voltage = $measurements['dc_voltage'];

			$this->update_with($timestamp, $generation, $ac_power, $dc_voltage);

		}
	}

}

?>
