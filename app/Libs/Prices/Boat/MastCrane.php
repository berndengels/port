<?php
namespace App\Libs\Prices\Boat;

use DatePeriod;
use App\Libs\Prices\IPrice;

class MastCrane extends Main implements IPrice
{
    public function __construct(bool $useMastCrane, int $mastWeight)
    {
        $this->initConfig();
        $this->useMastCrane = $useMastCrane;
        $this->mastWeight   = $mastWeight;
    }

    public function addPrice()
    {
        if($this->useMastCrane && $this->mastWeight > 0) {
            if($this->mastWeight < 100) {
                return $this->priceMastCrane;
            } else {
                return $this->priceMastCrane + $this->priceMastCraneUpperWeight * $this->mastWeight / 100;
            }
        }
        return 0;
    }
}
