<?php namespace Mocks;

use App\Contracts\Inverter as InverterContract;

class DummyInverter implements InverterContract {
    public function ac_power()     { return 0; }
    public function dc_power()     { return 0; }
    public function efficiency()   { return 0; }
    public function ac_voltage()   { return 0; }
    public function dc_voltage()   { return 0; }
    public function ac_current()   { return 0; }
    public function dc_current()   { return 0; }
    public function ac_frequency() { return 0; }
}
    
?>
