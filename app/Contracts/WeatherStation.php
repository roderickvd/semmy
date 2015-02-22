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
	 * Get the current cloudiness in percent.
	 *
	 * @return int
	 */
	public function cloudiness();

}

?>
