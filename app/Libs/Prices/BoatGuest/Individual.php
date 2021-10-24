<?php
namespace App\Libs\Prices\BoatGuest;

use DatePeriod;
use App\Libs\Prices\IPrice;

class Individual extends Main implements IPrice
{
    public function __construct($individualPrice = 0)
    {
        $this->initConfig();
        $this->individualPrice = $individualPrice;
    }

    public function addPrice()
    {
        return $this->individualPrice ?: 0;
    }

    /**
     * @return DatePeriod
     */
    public function getIndividualPrice()
    {
        return $this->individualPrice;
    }

    /**
     * @param DatePeriod $individualPrice
     * @return Individual
     */
    public function setIndividualPrice($individualPrice): Individual
    {
        $this->individualPrice = $individualPrice;
        return $this;
    }
}
