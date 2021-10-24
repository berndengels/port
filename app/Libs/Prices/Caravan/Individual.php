<?php
namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\CaravanPrice;
use DatePeriod;
use App\Libs\Prices\IPrice;

class Individual implements IPrice
{
    /**
     * @var DatePeriod
     */
    protected $individualPrice;

    public function __construct($individualPrice = 0)
    {
        $this->individualPrice = $individualPrice;
    }

    public function addPrice(DatePeriod $days)
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
