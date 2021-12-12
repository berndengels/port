<?php
namespace App\Libs\Prices\Boat;

use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;

class SpecialPrice extends Main implements IPrice
{
    public function __construct(protected $specialPrice = null)
    {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        return new Price(0);
    }

    public function setPrice(): Price
    {
        return new Price(value: $this->specialPrice ?: 0);
    }

    /**
     * @return null
     */
    public function getSpecialPrice()
    {
        return $this->specialPrice;
    }

    /**
     * @param null $specialPrice
     * @return SpecialPrice
     */
    public function setSpecialPrice($specialPrice): SpecialPrice
    {
        $this->specialPrice = $specialPrice;
        return $this;
    }
}
