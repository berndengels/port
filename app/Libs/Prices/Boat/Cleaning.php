<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;

class Cleaning extends Main implements IPrice
{
    public function __construct(
        protected bool $cleaning,
        protected int $length
    ) {
        $this->initConfig();
    }


    public function addPrice(): Price
    {
        if($this->cleaning && $this->length > 0) {
            return new Price(ceil($this->priceCleaningPerLength * $this->length));
        }
        return new Price(0);
    }
}
