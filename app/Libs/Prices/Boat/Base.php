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
        dd($this->length * $this->width);
        $this->defaultSaisonPrice   = round($this->priceSaisonFactor * $this->length * $this->width);
        $this->defaultWinterPrice   = round($this->priceWinterFactor * $this->length * $this->width);
    }


    public function addPrice(DatePeriod $days): Price
    {
        $from   = $days->getStartDate();
        $until  = $days->getEndDate();

        switch($this->modus) {
            case 'saison':
                return $this->getSaisonPrice($from, $until);
            case 'winter':
                return $this->getWinterPrice($from, $until);
            default:
                return new Price();
        }
    }

    public function getSaisonPrice(Carbon $from = null, Carbon $until = null): Price
    {
        if(!$from && !$until) {
            return new Price(value: $this->defaultSaisonPrice);
        }
        $from   = !$from ? $this->saisonStart : $from;
        $until  = !$until ? $this->saisonEnd : $until;
        $days   = $until->diffInDays($from);
        return new Price(value:  round($this->defaultSaisonPrice * $days / $this->defaultSaisonDays));
    }

    public function getWinterPrice(Carbon $from = null, Carbon $until = null): Price
    {
        if(!$from && !$until) {
            return new Price(value: $this->defaultWinterPrice);
        }
        $from   = !$from ? $this->winterStart : $from;
        $until  = !$until ? $this->winterEnd : $until;
        $days   = $until->diffInDays($from);

        return new Price(value: round($this->defaultWinterPrice * $days / $this->defaultWinterDays));
    }
}
