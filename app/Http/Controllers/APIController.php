<?php namespace App\Http\Controllers;

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

		$response = [
			'version' => 1,

			'id' => [
				'name'	=> $pv_name,
				'power' => $pv_power
			],
			
			'measurements' => $this->inverter->measurements()
		];

		return view('api/v1/measurements', compact('response'));
	}

}
