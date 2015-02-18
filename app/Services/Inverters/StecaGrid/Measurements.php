<?php namespace App\Services\Inverters\StecaGrid;

use App\Facades\HTTP;
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

	const MEASUREMENTS_URI = '/gen.measurements.table.js';
	const COLUMN_MAPPING = [
		'dc_power'	   =>  2,
		'dc_voltage'   =>  5,
		'dc_current'   =>  8,
		'ac_voltage'   => 11,
		'ac_current'   => 14,
		'ac_frequency' => 17,
		'ac_power'	   => 20
	];

	const UPDATE_INTERVAL = 2;	// seconds

	protected $ip_address;
	protected $measurements = [];
	protected $last_updated_at = 0;

	/**
	 * Create a new StecaGrid Measurements instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->ip_address = env('INV_IP_ADDRESS', '127.0.0.1');

		// Initialize an empty array, so the app works even if the inverter if offline.
		foreach (self::COLUMN_MAPPING as $key => $value) {
			$this->measurements[$key] = null;
		}
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
		$response = HTTP::get($url);

		if ($response) {
			// Suppress errors regarding malformed HTML.
			libxml_use_internal_errors(true);

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
	 * Calculate and update the inverter efficiency.
	 *
	 * @return void
	 */
	protected function calculate_efficiency()
	{
		$ac_power = $this->measurements['ac_power'];
		$dc_power = $this->measurements['dc_power'];

		$efficiency = null;
		if ($dc_power > 0) {
			$efficiency = ($ac_power / $dc_power) * 100;
		}
		
		$this->measurements['efficiency'] = $efficiency;
	}

	/**
	 * Update the inverter measurements.
	 *
	 * @return void
	 */
	protected function update_measurements()
	{
		$this->get_measurements();
		$this->calculate_efficiency();
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
