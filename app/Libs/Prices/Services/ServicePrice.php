<?php

namespace App\Libs\Prices\Services;

use App\Libs\Prices\Price;

class ServicePrice
{
    protected $price;

    public function __construct(
        protected string $targetValue,
        protected float $pricePerUntit
    ) {
        $this->price = new Price($this->targetValue * $this->pricePerUntit);
    }

    public function getPrice() {
        return $this->price->getValue();
    }
}
