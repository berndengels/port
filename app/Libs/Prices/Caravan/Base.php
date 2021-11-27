<?php
namespace App\Libs\Prices\Caravan;

use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;

class Base extends Main implements IDailyPrice
{
    public function __construct(protected int $carlength = 0)
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
                $price = isset($this->saisonPricePerDay[$this->carlength]) ? $this->saisonPricePerDay[$this->carlength] : 0;
            }
            // nebensaison
            else
            {
                $price = isset($this->defaultPricePerDay[$this->carlength]) ? $this->defaultPricePerDay[$this->carlength] : 0;
            }
            $sumPrice += $price;
        }
        return new Price(value: $sumPrice);
    }

    /**
     * @return int
     */
    public function getCarlength(): int
    {
        return $this->carlength;
    }

    /**
     * @param  int $carlength
     * @return Base
     */
    public function setCarlength(int $carlength): Base
    {
        $this->carlength = $carlength;
        return $this;
    }
}
