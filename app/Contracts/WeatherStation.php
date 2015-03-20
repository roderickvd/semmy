<?php namespace App\Contracts;

interface WeatherStation {
	
	/*
	|--------------------------------------------------------------------------
	| Weather Station Contract
	|--------------------------------------------------------------------------
	|
	| This contract specifies which methods a weather station must implement.
	|
	*/

	/**
	 * Get the current temperature in degrees Celcius.
	 *
	 * @return float
	 */
	public function temperature();

	/**
	 * Get the minimum interval in seconds before refreshing the measurements.
	 *
	 * @return int
	 */
	public function update_interval();

}

?>
