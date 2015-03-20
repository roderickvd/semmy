<?php namespace App\Services\Inverters;

use App\Contracts\Inverter as InverterContract;

class DummyInverter implements InverterContract {

	/*
	|--------------------------------------------------------------------------
	| Dummy Inverter
	|--------------------------------------------------------------------------
	|
	| This dummy inverter immediately returns static values.
	|
	*/

	/**
	 * Get the AC power from the inverter.
	 *
	 * @return number
	 */
    public function ac_power() { return 1000.01; }

	/**
	 * Get the DC power from the inverter.
	 *
	 * @return number
	 */
    public function dc_power() { return 900.02; }

	/**
	 * Get the AC voltage from the inverter.
	 *
	 * @return number
	 */
    public function ac_voltage() { return 230.03; }

	/**
	 * Get the DC voltage from the inverter.
	 *
	 * @return number
	 */
    public function dc_voltage() { return 300.04; }

	/**
	 * Get the AC current from the inverter.
	 *
	 * @return number
	 */
    public function ac_current() { return 4.05; }

	/**
	 * Get the DC current from the inverter.
	 *
	 * @return number
	 */
    public function dc_current() { return 3.06; }

	/**
	 * Get the AC frequency from the inverter.
	 *
	 * @return number
	 */
    public function ac_frequency() { return 50.07; }

	/**
	 * Get the AC/DC conversion efficiency from the inverter.
	 *
	 * @return number
	 */
    public function efficiency()
    {
        return ($this->dc_power() / $this->ac_power() * 100);
    }

	/**
	 * Get today's yield from the inverter.
	 *
	 * @return number
	 */
    public function generation() { return 4000; }

	/**
	 * Get all values above as an associative array.
	 *
	 * @return array
	 */
    public function measurements() {
        return [
            'ac_power'     => $this->ac_power(),
            'dc_power'     => $this->dc_power(),
            'ac_voltage'   => $this->ac_voltage(),
            'dc_voltage'   => $this->dc_voltage(),
            'ac_current'   => $this->ac_current(),
            'dc_current'   => $this->dc_current(),
            'ac_frequency' => $this->ac_frequency(),
            'efficiency'   => $this->efficiency(),
			'generation'   => $this->generation()
        ];
    }

	/**
	 * Get the minimum interval in seconds before refreshing the measurements.
	 *
	 * @return int
	 */
	public function update_interval()
	{
		return 0;
	}

}

?>
