<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;

class Cleaning extends Main implements IPrice
{
    public function __construct(
        protected bool $cleaning = false,
        protected ?float $length = null,
        protected ?float $width = null,
		protected ?int $duration_cleaning = null
    ) {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        if(true === $this->cleaning && $this->length && $this->width) {
            try {
                $value = match($this->priceType) {
                    'length'	=> $this->unitPrice * $this->length,
                    'area'		=> $this->unitPrice * $this->length * $this->width,
					'hour' 		=> $this->unitPrice * $this->duration_cleaning,
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
        return new Price(0);
    }
}
