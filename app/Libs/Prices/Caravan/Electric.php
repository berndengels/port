<?php
namespace App\Libs\Prices\Caravan;

use DatePeriod;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;

class Electric extends Main implements IDailyPrice
{

    public function __construct(protected bool $useElectric)
    {
        $this->initConfg();
    }

    public function addPrice(DatePeriod $days): Price
    {
        $value = 0;
        if($this->useElectric) {
            $value = $this->daysCount * $this->priceElectricPerDay;
        }
        return new Price($value);
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
