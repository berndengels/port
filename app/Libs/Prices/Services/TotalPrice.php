<?php

namespace App\Libs\Prices\Services;

use App\Libs\Prices\Price;

/**
 *
 */
class TotalPrice
{
    /**
     * @var Price
     */
    protected $total;

    /**
     * @param float $materialPrice
     * @param float $servicePrice
     */
    public function __construct(
        protected MaterialPrice $materialPrice,
        protected ServicePrice $servicePrice
    )
    {
        $this->total = new Price($this->materialPrice->getPrice() + $this->servicePrice->getPrice());
    }

    /**
     * @return float|int
     */
    public function getTotal(): float|int
    {
        return $this->total->getValue();
    }
}
