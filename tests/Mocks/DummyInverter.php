<?php namespace Mocks;

use App\Contracts\Inverter as InverterContract;

class DummyInverter implements InverterContract {
    public function ac_power()     { return 1000.01; }
    public function dc_power()     { return  900.02; }
    public function efficiency()   { return   90.01; }
    public function ac_voltage()   { return  230.03; }
    public function dc_voltage()   { return  300.04; }
    public function ac_current()   { return    4.05; }
    public function dc_current()   { return    3.06; }
    public function ac_frequency() { return   50.07; }
}
    
?>
