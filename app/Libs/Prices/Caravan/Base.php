<?php
namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\CaravanPrice;
use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\IPrice;

class Base implements IPrice
{
    /**
     * @var int
     */
    protected $carLength;

    public function __construct(int $carLength = 0)
    {
        $this->carLength = $carLength;
    }

    public function addPrice(DatePeriod $days)
    {
        $saisonFromMonth    = config('port.main.dates.saison.fromMonth');
        $saisonUntilMonth   = config('port.main.dates.saison.untilMonth');
        $defaultPricePerDay = config('port.prices.caravan.default_per_day');
        $saisonPricePerDay  = config('port.prices.caravan.saison_per_day');
        $sumPrice = 0;
        /**
         * @var Carbon $date
         */
        foreach($days as $date) {
            if($date->month >= $saisonFromMonth && $date->month <= $saisonUntilMonth) {
                $price = isset($saisonPricePerDay[$this->carLength]) ? $saisonPricePerDay[$this->carLength] : 0;
            }
            // neben saison
            else
            {
                $price = isset($defaultPricePerDay[$this->carLength]) ? $defaultPricePerDay[$this->carLength] : 0;
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
