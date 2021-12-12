<?php

namespace App\Libs\Prices;

class Tax
{

    public function __construct()
    {
    }

    public function basePrice(): float
    {
        return 0;
    }

    public function taxedPrice(): float
    {
        return 0;
    }

    public function taxPrice(): float
    {
        return 0;
    }

    public function taxRate(): float
    {
        if(config('port.prices.tax.enabled')) {
            return config('port.prices.tax.rate');
        }
        return 0;
    }
}
