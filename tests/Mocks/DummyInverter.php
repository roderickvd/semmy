<?php namespace Mocks;

use App\Contracts\Inverter as InverterContract;

class DummyInverter implements InverterContract {
    public function ac_power()     { return 1000.01; }
    public function dc_power()     { return  900.02; }
    public function ac_voltage()   { return  230.03; }
    public function dc_voltage()   { return  300.04; }
    public function ac_current()   { return    4.05; }
    public function dc_current()   { return    3.06; }
    public function ac_frequency() { return   50.07; }

    public function efficiency()
    {
        return ($this->dc_power() / $this->ac_power() * 100);
    }

    public function measurements() {
        return [
            'ac_power'     => $this->ac_power(),
            'dc_power'     => $this->dc_power(),
            'ac_voltage'   => $this->ac_voltage(),
            'dc_voltage'   => $this->dc_voltage(),
            'ac_current'   => $this->ac_current(),
            'dc_current'   => $this->dc_current(),
            'ac_frequency' => $this->ac_frequency(),
            'efficiency'   => $this->efficiency()
        ];
    }
}
    
?>
