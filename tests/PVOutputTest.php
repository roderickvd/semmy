<?php

class PVOutputTest extends TestCase {

	/**
	 * Test that Semmy creates a correct status update.
	 *
	 * @return void
	 */
	public function testPVOutputUpdateWithTemperature()
	{
		$this->setResponse('SaveResponse');
		$http = $this->app->make('App\Contracts\HTTP');

		$timestamp = time();
		$time = str_replace(':', '%3A', date('H:i', $timestamp));
		$date = date('Ymd', $timestamp);

		$generation = $this->inverter->generation();
		$ac_power   = $this->inverter->ac_power();
		$dc_voltage = $this->inverter->dc_voltage();

		$api_key = env('PVOUTPUT_API_KEY');
		$sid     = env('PVOUTPUT_SID');

		$temperature = $this->app->make('App\Contracts\WeatherStation')->temperature();
		$this->app->make('App\Console\Commands\Loggers\PVOutputLogger')->update();

		$this->assertContains("X-Pvoutput-Apikey: {$api_key}", $http::$headers);
		$this->assertContains("X-Pvoutput-SystemId: {$sid}", $http::$headers);
		$this->assertEquals("d={$date}&t={$time}&v1={$generation}&v2={$ac_power}&v6={$dc_voltage}&v5={$temperature}", $http::$data);

		$this->app->singleton('App\Contracts\WeatherStation', 'App\Services\WeatherStations\NullService');
		$this->app->make('App\Console\Commands\Loggers\PVOutputLogger')->update();

		$this->assertContains("X-Pvoutput-Apikey: {$api_key}", $http::$headers);
		$this->assertContains("X-Pvoutput-SystemId: {$sid}", $http::$headers);
		$this->assertEquals("d={$date}&t={$time}&v1={$generation}&v2={$ac_power}&v6={$dc_voltage}", $http::$data);		
	}

}

?>
