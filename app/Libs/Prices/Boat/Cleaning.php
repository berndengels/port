<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;

class Cleaning extends Main implements IPrice
{
    public function __construct(bool $useCleaning, int $length)
    {
        $this->initConfig();
        $this->useCleaning  = $useCleaning;
        $this->length       = $length;
    }


    public function addPrice()
    {
        if($this->useCleaning && $this->length > 0) {
            return ceil($this->priceCleaningPerLength * $this->length);
        }
        return 0;
    }
}
