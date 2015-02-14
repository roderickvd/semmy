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

}
