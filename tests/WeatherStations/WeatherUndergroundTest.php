<?php

class WeatherUndergroundTest extends TestCase {

	/**
	 * Test that the WeatherUnderground adapter returns correct measurements.
	 *
	 * @return void
	 */
	public function testWeatherUndergroundWeatherConditions()
	{
		$this->setResponse('WeatherStations\WeatherUndergroundResponse');
		$weatherunderground = $this->app->make('App\Services\WeatherStations\WeatherUndergroundService');
		$this->assertEquals(12.4, $weatherunderground->temperature());
	}

}

?>
