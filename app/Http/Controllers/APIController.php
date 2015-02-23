<?php namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;

class APIController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| API Controller
	|--------------------------------------------------------------------------
	|
	| This controller implements Semmy's API.
	|
	*/

	/**
	 * Return the current inverter measurements to the caller.
	 *
	 * @return Response
	 */
	public function measurements_v1()
	{
		$pv_name  = env('PV_NAME', 'My Solar Power Plant');
		$pv_power = env('PV_POWER', 6700);

		$measurements = [
			'version' => 1,

			'id' => [
				'name'	=> $pv_name,
				'power' => $pv_power
			],
			
			'measurements' => $this->inverter->measurements(),

		];

		// Cache for 10 seconds to not hammer the inverter
		return response()->json($measurements)->setTtl(self::INVERTER_TTL);
	}

	/**
	 * Return the current weather to the caller.
	 *
	 * @return Response
	 */
	public function weather_v1()
	{
		$weather_station = App::make('App\Contracts\WeatherStation');
		$weather = [
			'temperature' => $weather_station->temperature()
		];

		// Cache for 10 minutes to save external API requests
		return response()->json($weather)->setTtl(self::WEATHER_TTL);
	}

}
