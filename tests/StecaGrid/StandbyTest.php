<?php

class StecaGridStandbyTest extends TestCase {
    
    protected $inverter;

    /**
     * Mocks a StecaGrid Web Portal.
     *
     * @return void
     */
    public function setUp()
    {
        global $standby;
        
        parent::setUp();

		require_once __DIR__ . './../Mocks/StecaGrid.php';
        $standby = true;
        $this->inverter = $this->app->make('App\Services\StecaGrid');
    }

	/**
	 * Test that the StecaGrid service returns the correct AC power.
	 *
	 * @return void
	 */
	public function testACPower()
	{        
        $this->assertEquals(null, $this->inverter->ac_power());
	}

	/**
	 * Test that the StecaGrid service returns the correct DC power.
	 *
	 * @return void
	 */
	public function testDCPower()
	{        
        $this->assertEquals(null, $this->inverter->dc_power());
	}

	/**
	 * Test that the StecaGrid service returns the correct efficiency.
	 *
	 * @return void
	 */
	public function testEfficiency()
	{        
        $this->assertEquals(null, $this->inverter->efficiency(), '', 0.01);
	}

	/**
	 * Test that the StecaGrid service returns the correct AC voltage.
	 *
	 * @return void
	 */
	public function testACVoltage()
	{        
        $this->assertEquals(null, $this->inverter->ac_voltage());
	}

	/**
	 * Test that the StecaGrid service returns the correct DC voltage.
	 *
	 * @return void
	 */
	public function testDCVoltage()
	{        
        $this->assertEquals(0.10, $this->inverter->dc_voltage());
	}

	/**
	 * Test that the StecaGrid service returns the correct AC current.
	 *
	 * @return void
	 */
	public function testACCurrent()
	{        
        $this->assertEquals(null, $this->inverter->ac_current());
	}
    
	/**
	 * Test that the StecaGrid service returns the correct DC current.
	 *
	 * @return void
	 */
	public function testDCCurrent()
	{        
        $this->assertEquals(null, $this->inverter->dc_current());
	}

	/**
	 * Test that the StecaGrid service returns the correct AC frequency.
	 *
	 * @return void
	 */
	public function testACFrequency()
	{        
        $this->assertEquals(null, $this->inverter->ac_frequency());
	}

}
