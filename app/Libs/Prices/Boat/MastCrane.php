<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\Price;
use App\Libs\Prices\IPrice;

class MastCrane extends Main implements IPrice
{
    public function __construct(
        protected bool $useMastCrane,
        protected int $mastWeight
    ) {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        $value = 0;
        if($this->useMastCrane && $this->mastWeight > 0) {
            if($this->mastWeight < 100) {
                $value = $this->priceMastCrane;
            } else {
                $value = $this->priceMastCrane + $this->priceMastCraneUpperWeight * $this->mastWeight / 100;
            }
        }
        return new Price($value);
    }
}
