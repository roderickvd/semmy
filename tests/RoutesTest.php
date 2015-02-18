<?php

class RoutesTest extends TestCase {

	/**
	 * Test that the application root is accessible.
	 *
	 * @return void
	 */
	public function testMonitorIndex()
	{
		$response = $this->call('GET', '/');
		$this->assertResponseOk();
	}

	/**
	 * Test that the measurements API is accessible (v1.0).
	 *
	 * @return void
	 */
	public function testMeasurementsApiV1()
	{
		$response = $this->call('GET', '/api/v1/measurements');
		$this->assertResponseOk();
	}

}
