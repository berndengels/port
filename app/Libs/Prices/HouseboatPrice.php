<?php

namespace App\Libs\Prices;

use App\Libs\Prices\Boat\Base;
use App\Libs\Prices\Boat\Cleaning;
use App\Libs\Prices\Boat\SpecialPrice;
use Illuminate\Support\Collection;

class HouseboatPrice extends PriceCalculator
{
    /**
     * @var int
     */
    protected static $priceBase = 0;

    public function params(): Collection
    {
        return collect([]);
    }

    protected function registerAddPriceClasses(): Collection
    {
        return collect([
            Base::class,
        ]);
    }
}
