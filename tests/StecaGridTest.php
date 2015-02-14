<?php

class StecaGridTest extends TestCase {
    
    protected $inverter;

    /**
     * Mocks a StecaGrid Web Portal.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

		require_once __DIR__ . '/Mocks/StecaGrid.php';
        $this->inverter = $this->app->make('App\Services\StecaGrid');
    }

	/**
	 * Test that the StecaGrid service returns the correct AC power.
	 *
	 * @return void
	 */
	public function testACPower()
	{        
        $this->assertEquals(84.62, $this->inverter->ac_power());
	}

	/**
	 * Test that the StecaGrid service returns the correct DC power.
	 *
	 * @return void
	 */
	public function testDCPower()
	{        
        $this->assertEquals(91.53, $this->inverter->dc_power());
	}

	/**
	 * Test that the StecaGrid service returns the correct efficiency.
	 *
	 * @return void
	 */
	public function testEfficiency()
	{        
        $this->assertEquals(92.45, $this->inverter->efficiency(), '', 0.01);
	}

	/**
	 * Test that the StecaGrid service returns the correct AC voltage.
	 *
	 * @return void
	 */
	public function testACVoltage()
	{        
        $this->assertEquals(222.27, $this->inverter->ac_voltage());
	}

	/**
	 * Test that the StecaGrid service returns the correct DC voltage.
	 *
	 * @return void
	 */
	public function testDCVoltage()
	{        
        $this->assertEquals(306.76, $this->inverter->dc_voltage());
	}

	/**
	 * Test that the StecaGrid service returns the correct AC current.
	 *
	 * @return void
	 */
	public function testACCurrent()
	{        
        $this->assertEquals(0.44, $this->inverter->ac_current());
	}
    
	/**
	 * Test that the StecaGrid service returns the correct DC current.
	 *
	 * @return void
	 */
	public function testDCCurrent()
	{        
        $this->assertEquals(0.30, $this->inverter->dc_current());
	}

	/**
	 * Test that the StecaGrid service returns the correct AC frequency.
	 *
	 * @return void
	 */
	public function testACFrequency()
	{        
        $this->assertEquals(49.99, $this->inverter->ac_frequency());
	}

}