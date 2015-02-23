<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Contracts\Inverter;
use App\Contracts\WeatherStation;

abstract class Controller extends BaseController {

	/**
	 * The cache time to live in seconds for inverter resources.
	 *
	 * @const int
	 */
	const INVERTER_TTL = 10;

	/**
	 * The cache time to live in seconds for weather resources.
	 *
	 * @const int
	 */
	const WEATHER_TTL = 600;	

	/**
	 * The configured inverter.
	 *
	 * @var App\Contracts\Inverter
	 */
	protected $inverter;
	
	/**
	 * Create a new controller instance.
	 *
	 * @param  \App\Contracts\Inverter  $inverter
	 * @return void
	 */
	public function __construct(Inverter $inverter)
	{
		$this->inverter = $inverter;
	}

}
