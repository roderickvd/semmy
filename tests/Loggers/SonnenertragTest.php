<?php

class SonnenertragTest extends TestCase {

	/**
	 * Test that Semmy creates a correct daily data entry.
	 *
	 * @return void
	 */
	public function testSonnenertragUpdate()
	{
		$this->setResponse('SaveResponse');
		$http = $this->app->make('App\Contracts\HTTP');

		$timestamp = time();
		$date  = date('Y-m-d', $timestamp);
		$month = date('n', $timestamp);
		$year  = date('Y', $timestamp);

		$generation = $this->inverter->generation();
		$kwh = $generation / 1000;

		$pb_id = env('SONNENERTRAG_PB_ID');
		
		$this->app->make('App\Console\Commands\Loggers\SonnenertragLogger')->update();
		$this->assertEquals("pb_id={$pb_id}&month={$month}&year={$year}&yield%5B{$date}%5D={$kwh}&is_auto_update%5B{$date}%5D=1&save=Save", $http::$data);
	}

}

?>
