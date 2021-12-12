<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;

class Cleaning extends Main implements IPrice
{
    public function __construct(
        protected bool $cleaning,
        protected float|int $length
    ) {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        if($this->cleaning && $this->length > 0) {
            $unitPrice = $this->priceComponents
                ->where('key','=', 'cleaning')
                ->first()
                ->unit_price
            ;
            return new Price(ceil($unitPrice * $this->length));
        }
        return new Price(0);
    }
}
