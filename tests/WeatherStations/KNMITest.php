<?php

class KNMITest extends TestCase {

	/**
	 * Test that the KNMI weather station adapter returns correct measurements.
	 *
	 * @return void
	 */
	public function testKNMIWeatherConditions()
	{
		$this->setResponse('WeatherStations\KNMIResponse');
		$knmi = $this->app->make('App\Services\WeatherStations\KNMIService');
		$this->assertEquals(7.4, $knmi->temperature());
	}

}

?>
