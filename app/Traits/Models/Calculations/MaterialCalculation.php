<?php

namespace App\Traits\Models\Calculations;

use Exception;
use App\Models\Boat;
use App\Models\Material;
use App\Libs\Calculations\Boat\Material\Quantity;

trait MaterialCalculation
{
    public function getQuantity(Boat $boat)
    {
        if(! $this instanceof Material) {
            throw new Exception('wrong model instance');
        }

        return (new Quantity(
            boat: $boat,
            fertility: $this->fertility,
            fertilityPer: $this->fertility_per,
            fertilityUnit: $this->fertility_unit
        ))->getQuantity();
    }
}
