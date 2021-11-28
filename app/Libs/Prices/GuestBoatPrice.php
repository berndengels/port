<?php

namespace App\Libs\Prices;

use App\Libs\Prices\GuestBoat\Electric;
use App\Libs\Prices\GuestBoat\Individual;
use App\Libs\Prices\GuestBoat\Persons;
use App\Libs\Prices\GuestBoat\Base;
use Illuminate\Support\Collection;

class GuestBoatPrice extends PriceCalculator
{
    protected static $priceBase;
    protected static $pricePersons;
    protected static $priceElectric;
    protected static $priceIndividual;

    public function params(): Collection
    {
        return collect(['persons', 'electric', 'day_price', 'length']);
    }

    public function registerAddPriceClasses(): Collection
    {
        return collect([
            Base::class,
            Electric::class,
            Persons::class,
        ]);
    }

    public function registerSetPriceClasses(): Collection
    {
        return collect([
            Individual::class
        ]);
    }
}
