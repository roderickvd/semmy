<?php namespace App\Services\Inverters;

use App\Contracts\Inverter as InverterContract;
use App\Services\Inverters\StecaGrid\Measurements as Measurements;

class StecaGrid implements InverterContract {

	/*
	|--------------------------------------------------------------------------
	| StecaGrid Inverter
	|--------------------------------------------------------------------------
	|
	| This is an adapter for StecaGrid inverters with an Ethernet interface.
	| Make sure that the Web Portal is enabled in the inverter settings,
	| and that the Web Portal has a "Measurements" page. If the Web
	| Portal has no such page, you need to update the firmware.
	|
	| This class delegates the actual implementation to the StecaGrid
	| Measurements class, so that the measurements may be memoized.
	|
	*/

	/**
	 * The instance of our measurements delegate.
	 *
	 * @var App\Services\Inverters\StecaGrid\Measurements
	 */
	protected $measurements;

	/**
	 * Create a new StecaGrid instance.
	 *
	 * @param  string  $ip_address
	 * @return void
	 */
	public function __construct(Measurements $measurements)
	{
		$this->measurements = $measurements;
	}

	/**
	 * Get the AC power from the inverter.
	 *
	 * @return number
	 */
	public function ac_power()
	{
		return $this->measurements->get('ac_power');
	}

	/**
	 * Get the AC voltage from the inverter.
	 *
	 * @return number
	 */
	public function ac_voltage()
	{
		return $this->measurements->get('ac_voltage');
	}

	/**
	 * Get the AC current from the inverter.
	 *
	 * @return number
	 */
	public function ac_current()
	{
		return $this->measurements->get('ac_current');
	}

	/**
	 * Get the AC frequency from the inverter.
	 *
	 * @return number
	 */
	public function ac_frequency()
	{
		return $this->measurements->get('ac_frequency');
	}

	/**
	 * Get the DC power from the inverter.
	 *
	 * @return number
	 */
	public function dc_power()
	{
		return $this->measurements->get('dc_power');
	}

	/**
	 * Get the DC voltage from the inverter.
	 *
	 * @return number
	 */
	public function dc_voltage()
	{
		return $this->measurements->get('dc_voltage');
	}

	/**
	 * Get the DC current from the inverter.
	 *
	 * @return number
	 */
	public function dc_current()
	{
		return $this->measurements->get('dc_current');
	}

	/**
	 * Get the AC/DC conversion efficiency from the inverter.
	 *
	 * @return number
	 */
	public function efficiency()
	{
		return $this->measurements->get('efficiency');
	}

	/**
	 * Get today's yield from the inverter.
	 *
	 * @return number
	 */
	public function generation()
	{
		return $this->measurements->get('generation');
	}

	/**
	 * Get all values above as an associative array.
	 *
	 * @return array
	 */
	public function measurements()
	{
		return $this->measurements->all();
	}

	/**
	 * Get the minimum interval in seconds before refreshing the measurements.
	 *
	 * @return int
	 */
	public function update_interval()
	{
		return Measurements::UPDATE_INTERVAL;
	}

}
	
?>
