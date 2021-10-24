<?php
namespace App\Libs\Prices\Boat;

use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\IDailyPrice;

class Base extends Main implements IDailyPrice
{

    public function __construct(string $modus, int $length, int $width)
    {
        $this->initConfig();
        $this->modus    = $modus;
        $this->length   = $length;
        $this->width    = $width;
        $this->defaultSaisonPrice   = round($this->priceSaisonFactor * $length * $width);
        $this->defaultWinterPrice   = round($this->priceWinterFactor * $length * $width);
    }


    public function addPrice(DatePeriod $days) : int
    {
        $from   = $days->getStartDate();
        $until  = $days->getEndDate();

        switch($this->modus) {
            case 'saison':
                return $this->getSaisonPrice($from, $until);
            case 'winter':
                return $this->getWinterPrice($from, $until);
            default:
                return 0;
        }
    }

    public function getSaisonPrice(Carbon $from = null, Carbon $until = null) : int
    {
        if(!$from && !$until) {
            return $this->defaultSaisonPrice;
        }
        $from   = !$from ? $this->saisonStart : $from;
        $until  = !$until ? $this->saisonEnd : $until;
        $days   = $until->diffInDays($from);

        return round($this->defaultSaisonPrice * $days / $this->defaultSaisonDays);
    }

    public function getWinterPrice(Carbon $from = null, Carbon $until = null) : int
    {
        if(!$from && !$until) {
            return $this->defaultWinterPrice;
        }
        $from   = !$from ? $this->winterStart : $from;
        $until  = !$until ? $this->winterEnd : $until;
        $days   = $until->diffInDays($from);

        return round($this->defaultWinterPrice * $days / $this->defaultWinterDays);
    }
}
