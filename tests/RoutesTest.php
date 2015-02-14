<?php

class RoutesTest extends TestCase {

    /**
     * Mocks a default dummy inverter.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

		require_once __DIR__ . '/Mocks/DummyInverter.php';
        $this->app->singleton('App\Contracts\Inverter', 'Mocks\DummyInverter');
    }

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
