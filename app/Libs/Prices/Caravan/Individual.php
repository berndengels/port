<?php
namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\IPrice;
use App\Libs\Prices\Price;

class Individual extends Main implements IPrice
{
    public function __construct(protected $individualPrice = null)
    {
        $this->initConfg();
    }

    public function addPrice(): Price
    {
        return new Price(0);
    }

    public function setPrice(): Price
    {
        return new Price(value: $this->individualPrice ?: 0);
    }

    /**
     * @return int
     */
    public function getIndividualPrice()
    {
        return $this->individualPrice;
    }

    /**
     * @param  DatePeriod $individualPrice
     * @return Individual
     */
    public function setIndividualPrice($individualPrice): Individual
    {
        $this->individualPrice = $individualPrice;
        return $this;
    }
}
