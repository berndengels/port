<?php
namespace App\Libs\Prices;

use App\Libs\Prices\Caravan\Base;
use App\Libs\Prices\Caravan\Persons;
use App\Libs\Prices\Caravan\Electric;
use Illuminate\Support\Collection;

class CaravanPrice extends PriceCalculator
{
    protected static $priceElectric = 0;
    protected static $pricePersons = 0;
    protected static $priceBase = 0;

    public function params(): Collection
    {
        return collect([
            'persons',
            'electric',
            'carlength',
        ]);
    }

    protected function registerAddPriceClasses(): Collection
    {
        return collect([
            Base::class,
            Electric::class,
            Persons::class,
        ]);
    }
}
