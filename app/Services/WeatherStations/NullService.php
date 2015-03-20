<?php namespace App\Services\WeatherStations;

use App\Contracts\WeatherStation as WeatherStationContract;

class NullService implements WeatherStationContract {

	/*
	|--------------------------------------------------------------------------
	| Null Weather Station
	|--------------------------------------------------------------------------
	|
	| This weather adapter just returns null.
	| It is mainly used for testing.
	|
	*/

	/**
	 * Get and memoize the current temperature in degrees Celcius.
	 *
	 * @return null
	 */
	public function temperature()
	{
		return null;
	}

	/**
	 * Get the minimum interval in seconds before refreshing the measurements.
	 *
	 * @return int
	 */
	public function update_interval()
	{
		return 0;
	}

}

?>
