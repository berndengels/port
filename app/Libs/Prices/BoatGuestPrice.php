<?php

namespace App\Libs\Prices;

use App\Libs\Prices\BoatGuest\Electric;
use App\Libs\Prices\BoatGuest\Individual;
use App\Libs\Prices\BoatGuest\Persons;
use App\Libs\Prices\BoatGuest\Base;
use Illuminate\Support\Collection;

class BoatGuestPrice extends PriceCalculator
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
