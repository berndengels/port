<?php
namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\CaravanPrice;
use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\IDailyPrice;

class Base extends Main implements IDailyPrice
{
    public function __construct(int $carLength = 0)
    {
        $this->initConfg();
        $this->carLength = $carLength;
    }

    public function addPrice(DatePeriod $days)
    {
        $sumPrice = 0;
        /**
         * @var Carbon $date
         */
        foreach($days as $date) {
            if($date->month >= $this->saisonFromMonth && $date->month <= $this->saisonUntilMonth) {
                $price = isset($this->saisonPricePerDay[$this->carLength]) ? $this->saisonPricePerDay[$this->carLength] : 0;
            }
            // neben saison
            else
            {
                $price = isset($this->defaultPricePerDay[$this->carLength]) ? $this->defaultPricePerDay[$this->carLength] : 0;
            }
            $sumPrice += $price;
        }
        return $sumPrice;
    }

    /**
     * @return int
     */
    public function getCarLength(): int
    {
        return $this->carLength;
    }

    /**
     * @param int $carLength
     * @return Base
     */
    public function setCarLength(int $carLength): Base
    {
        $this->carLength = $carLength;
        return $this;
    }
}
