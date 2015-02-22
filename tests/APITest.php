<?php

class APITest extends TestCase {

	/**
	 * Test that the measurements API returns the correct measurements (v1.0).
	 *
	 * @return void
	 */
	public function testMeasurementsAPIv1()
	{
		$response = $this->call('GET', '/api/v1/measurements');
		$values = json_decode($response->getContent());

        $this->assertEquals(1, $values->version);
        $this->assertEquals('Test Plant', $values->id->name);

        $this->assertEquals(2000.00, $values->id->power);
        $this->assertEquals(1000.01, $values->measurements->ac_power);
        $this->assertEquals( 900.02, $values->measurements->dc_power);
        $this->assertEquals(  90.00, $values->measurements->efficiency, '', 0.01);
        $this->assertEquals( 230.03, $values->measurements->ac_voltage);
        $this->assertEquals( 300.04, $values->measurements->dc_voltage);
        $this->assertEquals(   4.05, $values->measurements->ac_current);
        $this->assertEquals(   3.06, $values->measurements->dc_current);
        $this->assertEquals(  50.07, $values->measurements->ac_frequency);
	}

}

?>
