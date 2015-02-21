<?php namespace App\Services\Inverters\StecaGrid;

use App\Contracts\HTTP;
use DOMDocument;

class Measurements {

	/*
	|--------------------------------------------------------------------------
	| StecaGrid Measurements
	|--------------------------------------------------------------------------
	|
	| This delegate gets and memoizes the StecaGrid measurements. By hiding
	| the measurements array from the delegator, we ensure that they are
	| properly memoized.
	|
	*/

	/**
	 * The URI to the measurements JavaScript.
	 *
	 * @const string
	 */
	const MEASUREMENTS_URI = '/gen.measurements.table.js';

	/**
	 * The mapping of the measurements HTML to our associative array.
	 *
	 * @const array
	 */
	const COLUMN_MAPPING = [
		'dc_power'	   =>  2,
		'dc_voltage'   =>  5,
		'dc_current'   =>  8,
		'ac_voltage'   => 11,
		'ac_current'   => 14,
		'ac_frequency' => 17,
		'ac_power'	   => 20
	];

	/**
	 * The minimum interval before refreshing the measurements.
	 *
	 * @const int
	 */
	const UPDATE_INTERVAL = 2;	// seconds

	/**
	 * The timestamp of the last measurements update.
	 *
	 * @var int
	 */
	protected $last_updated_at = 0;

	/**
	 * The IP address to the inverter.
	 *
	 * @var string
	 */
	protected $ip_address;

	/**
	 * The associative array of measurements.
	 *
	 * @var array
	 */
	protected $measurements = [];


	/**
	 * The HTTP service.
	 *
	 * @var App\Contracts\HTTP
	 */
	protected $http;

	/**
	 * Create a new StecaGrid Measurements instance.
	 *
	 * @param  App\Contracts\HTTP  $http
	 * @return void
	 */
	public function __construct(HTTP $http)
	{
		$this->http = $http;
		$this->ip_address = env('INV_IP_ADDRESS', '127.0.0.1');

		// Initialize an empty array, so the app works even if the inverter if offline.
		foreach (self::COLUMN_MAPPING as $key => $value) {
			$this->measurements[$key] = null;
		}

		// Suppress errors regarding malformed HTML.
		libxml_use_internal_errors(true);
	}

	/**
	 * Parse an inverter measurement.
	 *
	 * @param  string  $key
	 * @param  string  $value
	 * @return void
	 */
	protected function parse_measurement($key, $value)
	{
		// Check if the inverter measurements are empty.
		$measurement = null;
		if (trim($value) != '---') {
			$measurement = floatval($value);
		}

		$this->measurements[$key] = $measurement;
	}

	/**
	 * Get the inverter measurements.
	 *
	 * @return void
	 */
	protected function get_measurements()
	{
		$url = "http://{$this->ip_address}" . self::MEASUREMENTS_URI;
		$response = $this->http->get($url);

		if ($response) {
			$dom = new DOMDocument();
			$dom->loadHTML($response);
			$elements = $dom->getElementsByTagName('td');

			foreach (self::COLUMN_MAPPING as $key => $index)
			{
				$this->parse_measurement($key, $elements[$index]->nodeValue);
			}			 
		}
	}

	/**
	 * Update the inverter measurements.
	 *
	 * @return void
	 */
	protected function update_measurements()
	{
		$prev_ac_power = $this->measurements['ac_power'];
		$prev_dc_power = $this->measurements['dc_power'];

		$this->get_measurements();

		// The AC power measurements of the StecaGrid lag behind the DC measurements.
		// As a consequence the instantaneous AC/DC conversion efficiency can be
		// greater than 100%. Try to prevent this by averaging two consecutive
		// measurements.

		$new_ac_power = $this->measurements['ac_power'];
		$new_dc_power = $this->measurements['dc_power'];

		$avg_ac_power = ($prev_ac_power + $new_ac_power) / 2;
		$avg_dc_power = ($prev_dc_power + $new_dc_power) / 2;

		$efficiency = null;
		if ($avg_dc_power > 0) {
			$efficiency = ($avg_ac_power / $avg_dc_power) * 100;
		}

		$this->measurements['efficiency'] = $efficiency;
	}

	/**
	 * Get and memoize all inverter measurements.
	 *
	 * @return array
	 */
	public function all()
	{
		$timestamp = time();
		if ($timestamp - $this->last_updated_at > self::UPDATE_INTERVAL) {
			$this->update_measurements();
			$this->last_updated_at = $timestamp;
		}

		return $this->measurements;
	}

	/**
	 * Get and memoize a particular inverter measurement.
	 *
	 * @param  string  $key
	 * @return number
	 */
	public function get($key)
	{
		return $this->all()[$key];
	}

}

?>
