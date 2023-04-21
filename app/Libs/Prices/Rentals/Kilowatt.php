<?php

namespace App\Libs\Prices\Rentals;

use App\Libs\Prices\Boat\Main;
use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;
use Illuminate\Database\Eloquent\Model;

class Kilowatt extends Main implements IPrice
{
    public function __construct(
        protected bool $kilowatt = false,
        protected int $kilowatt_value = 0,
        protected Model $rentable
    ) {
        $this->model = get_class($this->rentable);
        parent::__construct();
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        if(true === $this->kilowatt && $this->kilowatt_value > 0) {
            try {
                $value = match($this->priceType) {
                    'kilowatt' => $this->kilowatt_value > 0 ? $this->kilowatt_value * $this->unitPrice : $this->unitPrice,
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
