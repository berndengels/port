<?php
namespace App\Libs\Prices\BoatGuest;

use App\Libs\Prices\CaravanPrice;
use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Electric extends Main implements IDailyPrice
{
    public function __construct(bool $useElectric)
    {
        $this->initConfig();
        $this->useElectric = $useElectric;
    }

    public function addPrice(DatePeriod $days)
    {
        if($this->useElectric) {
            return iterator_count($days) * $this->priceElectricPerDay;
        }
        return 0;
    }

    /**
     * @return bool
     */
    public function isUseElectric(): bool
    {
        return $this->useElectric;
    }

    /**
     * @param bool $useElectric
     * @return Electric
     */
    public function setUseElectric(bool $useElectric): Electric
    {
        $this->useElectric = $useElectric;
        return $this;
    }
}
