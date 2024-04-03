<?php

namespace App\Libs\Prices;

use Illuminate\Support\Collection;
use App\Libs\Prices\Rentals\Base;
use App\Libs\Prices\Rentals\Kilowatt;
use App\Libs\Prices\Rentals\RentalCleaning;
use App\Libs\Prices\Traits\HasRentableModel;

class RentablePrice extends PriceCalculator
{
    use HasRentableModel;

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
			'rental_cleaning',
            'kilowatt',
            'kilowatt_value',
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
