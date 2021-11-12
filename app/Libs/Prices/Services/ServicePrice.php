<?php

namespace App\Libs\Prices\Services;

use App\Libs\Prices\Price;

class ServicePrice
{
    protected $price;

    public function __construct(
        protected string $unit,
        protected float $pricePerUntit
    ) {
        $this->price = new Price($this->unit * $this->pricePerUntit);
    }

    public function getPrice() {
        return $this->price->getValue();
    }
}
