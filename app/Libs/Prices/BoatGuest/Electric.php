<?php
namespace App\Libs\Prices\BoatGuest;

use App\Libs\Prices\CaravanPrice;
use App\Libs\Prices\Price;
use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Electric extends Main implements IDailyPrice
{
    public function __construct(protected bool $useElectric)
    {
        $this->initConfig();
    }

    public function addPrice(DatePeriod $days): Price
    {
        $value = 0;
        if($this->useElectric) {
            $value = $this->daysCount * $this->priceElectricPerDay;
        }

        return new Price((float) $value);
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
