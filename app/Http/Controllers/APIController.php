<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Contracts\Inverter;

class APIController extends Controller {

    /*
	|--------------------------------------------------------------------------
    | API Controller
    |--------------------------------------------------------------------------
    |
    | This controller implements Semmy's API.
    |
    */

    protected $inverter;
    
	/**
	 * Create a new API controller instance.
	 *
	 * @param  \App\Contracts\Inverter  $inverter
	 * @return void
	 */
    public function __construct(Inverter $inverter)
    {
        $this->inverter = $inverter;
    }

	/**
     * Return the current inverter measurements to the caller.
     *
     * @return Response
     */
    public function measurements_v1()
    {
        // Load configuration
        $pv_name  = env('PV_NAME', 'My Solar Power Plant');
        $pv_power = env('PV_POWER', 6700);

        $response = [];
        $response['version'] = '1';

        $response['id']['name']  = $pv_name;
        $response['id']['power'] = $pv_power;
        
        // Get the inverter measurements
        $response['measurements']['ac-power']     = $this->inverter->ac_power();
        $response['measurements']['dc-power']     = $this->inverter->dc_power();
        $response['measurements']['efficiency']   = $this->inverter->efficiency();
        $response['measurements']['ac-voltage']   = $this->inverter->ac_voltage();
        $response['measurements']['dc-voltage']   = $this->inverter->dc_voltage();
        $response['measurements']['ac-current']   = $this->inverter->ac_current();
        $response['measurements']['dc-current']   = $this->inverter->dc_current();
        $response['measurements']['ac-frequency'] = $this->inverter->ac_frequency();

        return view('api/v1/measurements', compact('response'));
    }

}
