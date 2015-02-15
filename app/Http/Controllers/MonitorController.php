<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Contracts\Inverter;

class MonitorController extends Controller {
    
    /*
	|--------------------------------------------------------------------------
    | Monitor Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders Semmy's "dashboard".
    |
    */
    
    protected $inverter;
    
	/**
	 * Create a new monitor controller instance.
	 *
	 * @param  \App\Contracts\Inverter  $inverter
	 * @return void
	 */
    public function __construct(Inverter $inverter)
    {
        $this->inverter = $inverter;
    }

	/**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        // Load configuration
        $pv_name  = env('PV_NAME', 'My Solar Power Plant');
        $pv_power = env('PV_POWER', 6700);

        $max_ac_power = env('MAX_AC_POWER', 5500);
        $max_dc_power = env('MAX_DC_POWER', 5620);

        $min_dc_voltage = env('MIN_DC_VOLTAGE', 125);
        $max_dc_voltage = env('MAX_DC_VOLTAGE', 800);
        
        $min_mpp_voltage = env('MIN_MPP_VOLTAGE', 160);
        $nom_mpp_voltage = env('NOM_MPP_VOLTAGE', 400);
        $max_mpp_voltage = env('MAX_MPP_VOLTAGE', 800);

        $min_ac_voltage = env('MIN_AC_VOLTAGE', 185);
        $nom_ac_voltage = env('NOM_AC_VOLTAGE', 230);
        $max_ac_voltage = env('MAX_AC_VOLTAGE', 276);
        
        $min_ac_frequency = env('MIN_AC_FREQUENCY', 45);
        $nom_ac_frequency = env('NOM_AC_FREQUENCY', 50);
        $max_ac_frequency = env('MAX_AC_FREQUENCY', 65);
        
        $max_dc_current = env('MAX_DC_CURRENT', 11);
        $max_ac_current = env('MAX_AC_CURRENT', 18.5);
        
        // Calculate stops for the graph color gradients
        $dc_voltage_min_stop     = $min_dc_voltage / $max_dc_voltage;
        $dc_voltage_min_mpp_stop = $min_mpp_voltage / $max_dc_voltage;
        $dc_voltage_nom_mpp_stop = $nom_mpp_voltage / $max_dc_voltage;
        $dc_voltage_max_mpp_stop = $max_mpp_voltage / $max_dc_voltage;
        
        $ac_voltage_nom_stop   = ($nom_ac_voltage - $min_ac_voltage) / ($max_ac_voltage - $min_ac_voltage);
        $ac_frequency_nom_stop = ($nom_ac_frequency - $min_ac_frequency) / ($max_ac_frequency - $min_ac_frequency);
        
        // Get the inverter measurements
        $ac_power     = $this->inverter->ac_power();
        $dc_power     = $this->inverter->dc_power();
        $efficiency   = $this->inverter->efficiency();
        $ac_voltage   = $this->inverter->ac_voltage();
        $dc_voltage   = $this->inverter->dc_voltage();
        $ac_current   = $this->inverter->ac_current();
        $dc_current   = $this->inverter->dc_current();
        $ac_frequency = $this->inverter->ac_frequency();
        
        return view('monitor', compact(
            'pv_name',
            'pv_power',
            'ac_power',
            'dc_power',
            'efficiency',
            'ac_voltage',
            'dc_voltage',
            'ac_current',
            'dc_current',
            'ac_frequency',                
            'max_dc_power',
            'max_dc_voltage',
            'dc_voltage_min_stop',
            'dc_voltage_min_mpp_stop',
            'dc_voltage_nom_mpp_stop',
            'dc_voltage_max_mpp_stop',
            'max_dc_current',
            'max_ac_power',
            'min_ac_voltage',
            'max_ac_voltage',
            'ac_voltage_nom_stop',
            'max_ac_current',
            'min_ac_frequency',
            'ac_frequency_nom_stop',
            'max_ac_frequency'
        ));
    }

}
