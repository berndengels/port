<?php
namespace App\Libs\Prices\GuestBoat;

use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use App\Libs\Prices\MainPriceItem;

abstract class Main extends MainPriceItem
{
    public static $dailyPrices = [];

    protected $dateModel = GuestBoatDates::class;
    protected $model = GuestBoat::class;

    protected $pricePerMeter;
    protected $priceElectricPerDay;
    protected $pricePersons = 0;
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
