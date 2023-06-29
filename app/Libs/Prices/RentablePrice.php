<?php

namespace App\Libs\Prices;

use Illuminate\Support\Collection;
use App\Libs\Prices\Rentals\Base;
use App\Libs\Prices\Rentals\Kilowatt;
use App\Libs\Prices\Rentals\RentalCleaning;
use App\Libs\Prices\Traits\HasModel;

class RentablePrice extends PriceCalculator
{
    use HasModel;

    /**
     * @var int
     */
    protected static $priceBase = 0;
    public static $dailyPrices;
    protected static $priceRentalCleaning = 0;
    protected static $priceKilowatt = 0;

    public function params(): Collection
    {
        return collect([
            'kilowatt',
            'kilowatt_value',
            'rental_cleaning',
        ]);
    }

    protected function registerAddPriceClasses(): Collection
    {
        return collect([
            Base::class,
            RentalCleaning::class,
            Kilowatt::class,
        ]);
    }
}
