<?php

namespace App\Libs\Prices;

use Illuminate\Support\Collection;
use App\Libs\Prices\GuestBoat\Base;
use App\Libs\Prices\GuestBoat\Electric;
use App\Libs\Prices\GuestBoat\Persons;

class GuestBoatPrice extends PriceCalculator
{
    protected static $priceBase;
    protected static $pricePersons;
    protected static $priceElectric;

    public function params(): Collection
    {
        return collect([
            'persons',
            'electric',
            'length',
            'berth_id',
        ]);
    }

    public function registerAddPriceClasses(): Collection
    {
        return collect([
            Base::class,
            Electric::class,
            Persons::class,
        ]);
    }
}
