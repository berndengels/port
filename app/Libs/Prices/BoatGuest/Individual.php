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
        return new Price(value: $this->individualPrice ?: 0);
    }

    /**
     * @return DatePeriod
     */
    public function getIndividualPrice(): Price
    {
        return new Price(value: $this->individualPrice);
    }

    /**
     * @param DatePeriod $individualPrice
     * @return Individual
     */
    public function setIndividualPrice($individualPrice): Individual
    {
        $this->individualPrice = new Price(value: $individualPrice);
        return $this;
    }
}
