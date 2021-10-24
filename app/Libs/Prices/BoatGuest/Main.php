<?php
namespace App\Libs\Prices\BoatGuest;

abstract class Main
{
    protected $length;
    protected $pricePerMeter;
    protected $priceElectricPerDay;
    protected $pricePersons = 0;
    protected $useElectric = false;
    protected $personsInclusive = 0;
    protected $personsAdditional = 0;

    protected function initConfig()
    {
        $this->pricePerMeter        = config('port.prices.boat_guest.price_per_meter');
        $this->priceElectricPerDay  = config('port.prices.boat_guest.electric_per_day');
        $this->personsInclusive     = config('port.prices.boat_guest.persons_inclusivce');
        $this->personsAdditional    = config('port.prices.boat_guest.persons_additional');
    }
}
