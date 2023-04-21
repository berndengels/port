<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;

class Crane extends Main implements IPrice
{
    public function __construct(
        protected bool $crane = false,
        protected ?int $weight = null
    ) {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        if(true === $this->crane && $this->weight) {
            try {
                $value = match($this->priceType) {
                    'ton' => $this->unitPrice * $this->weight / 1000,
                    'kilogram'=> $this->unitPrice * $this->weight,
                    default => $this->unitPrice,
                };
                return new Price($value);
            } catch(\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                    'value' => $value,
                ]);
            }
        }
        return new Price();
    }
}
