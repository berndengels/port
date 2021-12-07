<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\Price;
use App\Libs\Prices\IPrice;

class MastCrane extends Main implements IPrice
{
    public function __construct(
        protected bool $mast_crane,
        protected float|int $mast_weight
    ) {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        $value = 0;
        if($this->mast_crane && $this->mast_weight > 0) {
            $unitPrice = $this->priceComponents
                ->where('key','=', 'mast_crane')
                ->first()
                ->unit_price
            ;

            $value = $unitPrice * $this->mast_weight;
        }
        return new Price($value);
    }
}
