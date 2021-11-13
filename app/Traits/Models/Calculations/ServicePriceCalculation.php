<?php

namespace App\Traits\Models\Calculations;

use Exception;
use App\Models\Boat;
use App\Models\Service;
use App\Libs\Prices\Boat\Services\ServicePrice;

trait ServicePriceCalculation
{

    public function getServicePrice(Boat $boat)
    {
        if(! $this instanceof Service) {
            throw new Exception('wrong model instance');
        }

        return (new ServicePrice(
            boat: $boat,
            priceType: $this->priceType,
            pricePerUntit: $this->price
        ))->getPrice();
    }
}
