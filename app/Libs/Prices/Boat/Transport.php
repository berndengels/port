<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;

class Transport extends Main implements IPrice
{
    public function __construct(
        protected bool $transport = false,
        protected ?int $weight = null
    ) {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        if(true === $this->transport) {
            try {
                $value = match($this->priceType) {
                    'kilogram' => $this->unitPrice * $this->weight,
                    'ton' => $this->unitPrice * $this->weight / 1000,
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
