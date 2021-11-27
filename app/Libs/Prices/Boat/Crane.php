<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;

class Crane extends Main implements IPrice
{
    public function __construct(
        protected bool $crane,
        protected int $weight
    ) {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        if($this->crane) {
            return new Price($this->pricePerTon * $this->weight / 1000);
        }
        return new Price();
    }
}
