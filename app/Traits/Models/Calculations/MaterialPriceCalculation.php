<?php

namespace App\Traits\Models\Calculations;

use Exception;
use App\Models\Boat;
use App\Models\Material;
use App\Libs\Prices\Boat\Services\MaterialPrice;

trait MaterialPriceCalculation
{

    public function getMaterialPrice(Boat $boat)
    {
        if(! $this instanceof Material) {
            throw new Exception('wrong model instance');
        }
        return (new MaterialPrice(
            boat: $boat,
            fertility: $this->fertility,
            fertilityUnit: $this->fertility_unit,
            pricePerUnit: $this->price_per_unit
        ))->getPrice();
    }
}
