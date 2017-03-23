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
	 * The URI to the measurements JavaScript, depending on the firmware version.
	 *
	 * @const string
	 */
	const MEASUREMENTS_URI_V1 = '/gen.measurements.table.js';
	const MEASUREMENTS_URI_V2 = '/measurements.xml';

	/**
	 * The URI to the yield JavaScript.
	 *
	 * @const string
	 */
	const GENERATION_URI = '/gen.yield.day.chart.js';

	/**
	 * The mapping of the measurements HTML to our associative array.
	 *
	 * @const array
	 */

	// Array constants are not supported before PHP 5.6.
	protected static $COLUMN_MAPPING_V1 = [
		'dc_power'	   =>  2,
		'dc_voltage'   =>  5,
		'dc_current'   =>  8,
		'ac_voltage'   => 11,
		'ac_current'   => 14,
		'ac_frequency' => 17,
		'ac_power'	   => 20
	];

	protected static $COLUMN_MAPPING_V2 = [
		'dc_power'	   => 'GridPower',
		'dc_voltage'   => 'DC_Voltage',
		'dc_current'   => 'DC_Current',
		'ac_voltage'   => 'AC_Voltage',
		'ac_current'   => 'AC_Current',
		'ac_frequency' => 'AC_Frequency',
		'ac_power'	   => 'AC_Power'
	];

	/**
	 * The minimum interval before refreshing the measurements.
	 *
	 * @const int
	 */
	const UPDATE_INTERVAL = 10;	// seconds

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
		$this->ip_address = env('INV_IP_ADDRESS');
		if (!$this->ip_address) {
			abort(500, 'No IP address configured for StecaGrid inverter.');

		}

		$this->http = $http;

		// Initialize an empty array, so the app works even if the inverter if offline.
		$this->measurements['generation'] = null;
		foreach (self::$COLUMN_MAPPING as $key => $value) {
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
	 * Get an inverter resource.
	 *
	 * @param  string  $uri
	 * @return string
	 */
	protected function get_resource($uri)
	{
		$host = "http://{$this->ip_address}";
		return $this->http->get($host, $uri);
	}

	/**
	 * Fetch the instantaneous inverter measurements.
	 *
	 * @return void
	 */
	protected function fetch_measurements()
	{
		$response = $this->get_resource(self::MEASUREMENTS_URI_V1);
		if ($response) {
			$dom = new DOMDocument();
			$dom->loadHTML($response);
			$elements = $dom->getElementsByTagName('td');

			foreach (self::$COLUMN_MAPPING_V1 as $key => $index) {
				$this->parse_measurement($key, $elements->item($index)->nodeValue);
			}			 

		} else {

			$response = $this->get_resource(self::MEASUREMENTS_URI_V2);
			if ($response) {
				$measurements = [];
				$index = [];

				$parser = xml_parser_create();
				xml_parse_into_struct($parser, $response, $measurements, $index);
				xml_parser_free($parser);

				foreach ($measurements as $measurement) {
					if (@$type = $measurement["attributes"]["TYPE"]) {
						foreach (self::$COLUMN_MAPPING_V2 as $key => $index) {
							if ($type == $index) {
								@$value = $measurement["attributes"]["VALUE"];
								$this->parse_measurement($key, $value);
								break;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Fetch the inverter yield for today.
	 *
	 * @return void
	 */
	protected function fetch_generation()
	{
		$response = $this->get_resource(self::GENERATION_URI);
		if ($response) {
			preg_match('/(([1-9]\d*\.){0,1}\d+)kWh/', $response, $matches);
			$this->measurements['generation'] = intval(str_replace('.', '', $matches[1]));
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

		$this->fetch_measurements();
		$this->fetch_generation();

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
