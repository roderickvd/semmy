<?php namespace App\Services\Loggers;

use App\Contracts\HTTP;
use App\Contracts\Inverter;

class PVOutput {
	
	/*
	|--------------------------------------------------------------------------
	| PVOutput Logger
	|--------------------------------------------------------------------------
	|
	| This delegate gets and memoizes the StecaGrid measurements. By hiding
	| the measurements array from the delegator, we ensure that they are
	| properly memoized.
	|
	*/

	/**
	 * The URL to the PVOutput Status Service.
	 *
	 * @const string
	 */
	const STATUS_URL = 'http://pvoutput.org/service/r2/addstatus.jsp';

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
	public function __construct(HTTP $http, Inverter $inverter)
	{
		$this->http     = $http;
		$this->inverter = $inverter;

		$this->sid     = env('PVOUTPUT_SID');
		$this->api_key = env('PVOUTPUT_API_KEY');
	}

	/**
	 * Update PVOutput with a given set of measurements at a certain time.
	 *
	 * @param  int    $timestamp
	 * @param  array  $measurements
	 * @return void
	 */
	public function update_with($timestamp, $generation, $ac_power, $dc_voltage)
	{
		$headers = [
			"X-Pvoutput-Apikey:{$this->api_key}",
			"X-Pvoutput-SystemId:{$this->sid}"
		];

		$status = [
			'd'  => date('Ymd', $timestamp),
			't'  => date('H:i'),
			'v1' => $generation,
			'v2' => $ac_power,
			'v6' => $dc_voltage
		];

		$this->http->post(self::STATUS_URL, $status, $headers);
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
