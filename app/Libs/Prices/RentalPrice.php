<?php

namespace App\Libs\Prices;

use Illuminate\Support\Collection;
use App\Libs\Prices\Rentals\Base;

class RentalPrice extends PriceCalculator
{
    /**
     * @var int
     */
    protected static $priceBase = 0;
    public static $dailyPrices;
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
