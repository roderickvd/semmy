<?php namespace Mocks\StecaGrid;

class StandbyResponse {

    /*
	|--------------------------------------------------------------------------
    | Mock Standby StecaGrid HTTP Response
    |--------------------------------------------------------------------------
    |
    | This mock returns a real-world response that a StecaGrid inverter may
    | send when on standby.
    |
    */

    const STANDBY_RESPONSE = "document.write(\"<table class='invisible'><tr class='invisible'><th class='invisible'><h3>Inverter</h3></th><th class='invisible'><h3></h3></th></tr><tr class='invisible'><td class='invisible' valign='top' align='center'><table><tr><th>Name</th><th>Value</th><th>Unit</th></tr><tr><td>P DC</td><td align='right'> --- </td><td>W</td></tr><tr><td>U DC</td><td align='right'> 0</td><td>V</td></tr><tr><td>I DC</td><td align='right'> --- </td><td>A</td></tr><tr><td>U AC</td><td align='right'> --- </td><td>V</td></tr><tr><td>I AC</td><td align='right'> --- </td><td>A</td></tr><tr><td>F AC</td><td align='right'> --- </td><td>Hz</td></tr><tr><td>P AC</td><td align='right'> --- </td><td>W</td></tr></table></td><td class='invisible' valign='top' align='center'></table></td></tr></table>\");";

    public function get($url)
    {
        return self::STANDBY_RESPONSE;
    }

}

?>
