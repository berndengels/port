<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\Price;
use App\Libs\Prices\IPrice;

class MastCrane extends Main implements IPrice
{
    public function __construct(
        protected bool $mast_crane,
        protected int $mast_weight
    ) {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        $value = 0;
        if($this->mast_crane && $this->mast_weight > 0) {
            if($this->mast_weight < 100) {
                $value = $this->priceMastCrane;
            } else {
                $value = $this->priceMastCrane + $this->priceMastCraneUpperWeight * $this->mast_weight / 100;
            }
        }
        return new Price($value);
    }
}
