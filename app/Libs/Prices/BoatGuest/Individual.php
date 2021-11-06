<?php
namespace App\Libs\Prices\BoatGuest;

use App\Libs\Prices\Price;
use App\Libs\Prices\IPrice;

class Individual extends Main implements IPrice
{
    public function __construct(protected $individualPrice = null)
    {
        $this->initConfig();
    }

    public function addPrice(): Price
    {
        return new Price(value: (float) $this->individualPrice ?: 0);
    }

    /**
     * @return Price
     */
    public function getIndividualPrice(): Price
    {
        return new Price(value: $this->individualPrice);
    }

    /**
     * @param  int|float $individualPrice
     * @return Individual
     */
    public function setIndividualPrice($individualPrice): Individual
    {
        $this->individualPrice = new Price(value: (float) $individualPrice);
        return $this;
    }
}
