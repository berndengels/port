<?php
namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\CaravanPrice;
use DatePeriod;
use App\Libs\Prices\IPrice;

class Electric implements IPrice
{
    /**
     * @var bool
     */
    protected $useElectric;

    public function __construct(bool $useElectric)
    {
        $this->useElectric = $useElectric;
    }

    public function addPrice(DatePeriod $days)
    {
        if($this->useElectric) {
            $pricePerDay = config('port.prices.caravan.electric_per_day');
            return iterator_count($days) * $pricePerDay;
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
