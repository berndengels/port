<?php
namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\CaravanPrice;
use App\Libs\Prices\Price;
use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\IDailyPrice;

class Base extends Main implements IDailyPrice
{
    public function __construct(protected int $carLength = 0)
    {
        $this->initConfg();
    }

    public function addPrice(DatePeriod $days): Price
    {
        $sumPrice = 0;
        /**
         * @var Carbon $date
         */
        foreach($days as $date) {
            // saison
            if($date->month >= $this->saisonFromMonth && $date->month <= $this->saisonUntilMonth) {
                $price = isset($this->saisonPricePerDay[$this->carLength]) ? $this->saisonPricePerDay[$this->carLength] : 0;
            }
            // nebensaison
            else
            {
                $price = isset($this->defaultPricePerDay[$this->carLength]) ? $this->defaultPricePerDay[$this->carLength] : 0;
            }
            $sumPrice += $price;
        }
        return new Price(value: $sumPrice);
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
