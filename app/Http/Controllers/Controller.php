<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Contracts\Inverter;

abstract class Controller extends BaseController {

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

}
