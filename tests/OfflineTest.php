<?php

class OfflineTest extends TestCase {

    /**
     * Set up the HTTP facade to act as if the inverters were offline.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->setResponse('OfflineResponse');
    }

	/**
	 * Test that the adapters return all values as null when the inverter is offline.
	 *
	 * @return void
	 */
	public function testOffline()
	{        
		foreach (self::$SUPPORTED_INVERTERS as $inverter) {
			$this->setInverter($inverter);

			$this->assertEquals(null, $this->inverter->ac_power());
	        $this->assertEquals(null, $this->inverter->dc_power());
	        $this->assertEquals(null, $this->inverter->efficiency());
			$this->assertEquals(null, $this->inverter->ac_voltage());
			$this->assertEquals(null, $this->inverter->dc_voltage());
			$this->assertEquals(null, $this->inverter->ac_current());
			$this->assertEquals(null, $this->inverter->dc_current());
			$this->assertEquals(null, $this->inverter->ac_frequency());
			$this->assertEquals(null, $this->inverter->generation());

			$measurements = $this->inverter->measurements();

			$this->assertArrayHasKey('ac_power', $measurements);
			$this->assertArrayHasKey('dc_power', $measurements);
			$this->assertArrayHasKey('efficiency', $measurements);
			$this->assertArrayHasKey('ac_voltage', $measurements);
			$this->assertArrayHasKey('dc_voltage', $measurements);
			$this->assertArrayHasKey('ac_current', $measurements);
			$this->assertArrayHasKey('dc_current', $measurements);
			$this->assertArrayHasKey('ac_frequency', $measurements);
			$this->assertArrayHasKey('generation', $measurements);
		}
	}

}

?>
