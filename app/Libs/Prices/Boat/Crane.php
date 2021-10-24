<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;

class Crane extends Main implements IPrice
{
    protected $useCrane = false;
    protected $weight;

    public function __construct(bool $useCrane, $weight)
    {
        $this->initConfig();
        $this->useCrane = $useCrane;
        $this->weight   = $weight;
    }

    public function addPrice()
    {
        return $this->pricePerTon * $this->weight / 1000;
    }
}
