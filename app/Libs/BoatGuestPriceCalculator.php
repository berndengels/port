<?php
namespace App\Libs;

use Carbon\Carbon;

class BoatGuestPriceCalculator extends PriceCalculator
{
    protected $pricePerMeter;

    public function __construct()
    {
        $this->pricePerMeter = (float) config('port.prices.boat_guest.price_per_meter');
    }

    public function getPrice(Carbon $from, Carbon $until, $length)
    {
        $days  = $until->diffInDays($from);
        $price = $this->pricePerMeter * $length * $days;
        return $price;
    }
}
