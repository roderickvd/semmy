<?php

class OpenWeatherMapTest extends TestCase {

	/**
	 * Test that the OpenWeatherMap adapter returns correct measurements.
	 *
	 * @return void
	 */
	public function testOpenWeatherMapWeatherConditions()
	{
		$this->setResponse('WeatherStations\OpenWeatherMapResponse');
		$openweathermap = $this->app->make('App\Services\WeatherStations\OpenWeatherMapService');
		$this->assertEquals(5.48, $openweathermap->temperature());
	}

}

?>
