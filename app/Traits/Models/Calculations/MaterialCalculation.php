<?php

namespace App\Traits\Models\Calculations;

use App\Models\Material;
use App\Libs\Calculations\Material\Quantity;
use Exception;

trait MaterialCalculation
{
    public function getQuantity($targetValue)
    {
        if(! $this instanceof Material) {
            throw new Exception('wrong model instance');
        }

        return (new Quantity(
            targetValue: $targetValue,
            fertility: $this->fertility
        ))->getQuantity();
    }
}
