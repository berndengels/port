<?php

namespace App\Traits\Models\Calculations;

use App\Models\Material;
use App\Libs\Prices\Services\MaterialPrice;
use Exception;

trait MaterialPriceCalculation
{

    public function getMaterialPrice($targetValue)
    {
        if(! $this instanceof Material) {
            throw new Exception('wrong model instance');
        }
        return (new MaterialPrice(
            targetValue: $targetValue,
            fertility: $this->fertility,
            pricePerUnit: $this->price_per_unit
        ))->getPrice();
    }
}
