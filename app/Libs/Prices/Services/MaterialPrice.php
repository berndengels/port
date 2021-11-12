<?php

namespace App\Libs\Prices\Services;

use App\Libs\Prices\Price;

class MaterialPrice
{
    protected $price;

    public function __construct(
        protected float $area,
        protected float $fertility,
        protected float $pricePerUnit
    )
    {
        $this->price = new Price($this->area * $this->pricePerUnit / $this->fertility);
    }

    /**
     * @return float|int
     */
    public function getPrice(): float|int
    {
        return $this->price->getValue();
    }
}
