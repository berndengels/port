<?php

namespace App\Traits\Models\Calculations;

use App\Models\Service;
use App\Libs\Prices\Services\ServicePrice;
use Exception;

trait ServicePriceCalculation
{

    public function getServicePrice($targetValue)
    {
        if(! $this instanceof Service) {
            throw new Exception('wrong model instance');
        }

        return (new ServicePrice(
            targetValue: $targetValue,
            pricePerUntit: $this->price)
        )->getPrice();
    }
}
