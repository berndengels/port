<?php
namespace App\Libs\Prices\Boat;

use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;

class Base extends Main implements IDailyPrice
{
    public function __construct(
        protected Carbon|null $from = null,
        protected Carbon|null $until = null,
        protected string $modus,
        protected float $length,
        protected float $width
    ) {
        $this->initConfig();
        $this->defaultSaisonPrice   = round($this->priceSaisonFactor * $this->length * $this->width);
        $this->defaultWinterPrice   = round($this->priceWinterFactor * $this->length * $this->width);
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        if($this->modus) {
            switch($this->modus) {
                case 'summer':
                    $from = $days ? new Carbon($days->getStartDate()) : static::$saisonStart;
                    $until = $days ? new Carbon($days->getEndDate()) : static::$saisonEnd;

                    return $this->getSaisonPrice($from, $until);
                case 'winter':
                    $from = $days ? new Carbon($days->getStartDate()) : static::$winterStart;
                    $until = $days ? new Carbon($days->getEndDate()) : static::$winterEnd;

                    return $this->getWinterPrice($from, $until);
            }
        }

        return new Price();
    }

    public function getSaisonPrice(?Carbon $from = null, ?Carbon $until = null): Price
    {
        if(!$from && !$until) {
            return new Price(value: $this->defaultSaisonPrice);
        }
        $from   = !$from ? static::$saisonStart : $from;
        $until  = !$until ? static::$saisonEnd : $until;
        $days   = $until->diffInDays($from);

        return new Price(value:  round($this->defaultSaisonPrice * $days / $this->defaultSaisonDays));
    }

    public function getWinterPrice(?Carbon $from = null,?Carbon  $until = null): Price
    {
        if(!$from && !$until) {
            return new Price(value: $this->defaultWinterPrice);
        }
        $from   = !$from ? static::$winterStart : $from;
        $until  = !$until ? static::$winterEnd : $until;
        $days   = $until->diffInDays($from);

        return new Price(value: round($this->defaultWinterPrice * $days / $this->defaultWinterDays));
    }
}
