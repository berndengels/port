<?php
namespace App\Libs;

use Carbon\Carbon;

class BoatCalculator extends PriceCalculator
{

    /**
     * @var int
     */
    protected $priceSaisonFactor;
    /**
     * @var int
     */
    protected $priceWinterFactor;
    /**
     * @var Carbon
     */
    protected $saisonStart;
    /**
     * @var Carbon
     */
    protected $saisonEnd;
    /**
     * @var Carbon
     */
    protected $winterStart;
    /**
     * @var Carbon
     */
    protected $winterEnd;

    public function __construct()
    {
        $today = Carbon::today();
        $year = $today->format('Y');
        $nextYear = $today->copy()->addYear()->format('Y');
        $this->priceSaisonFactor  = config('port.prices.boat.price_saison_factor');
        $this->priceWinterFactor  = config('port.prices.boat.price_winter_factor');
        $this->saisonStart  = Carbon::make($year . '-' . config('port.prices.boat.saison_start'));
        $this->saisonEnd    = Carbon::make($year . '-' . config('port.prices.boat.saison_end'));
        $this->winterStart  = Carbon::make($year . '-' . config('port.prices.boat.winter_start'));
        $this->winterEnd    = Carbon::make($nextYear . '-' . config('port.prices.boat.winter_end'));
    }

    public function getSaisonPrice($length, $width, Carbon $from = null, Carbon $until = null)
    {
        $defaultPrice = $this->getDefaultSaisonPrice($length, $width);
        if(!$from && !$until) {
            return $defaultPrice;
        }
        $from   = !$from ? $this->saisonStart : $from;
        $until  = !$until ? $this->saisonEnd : $until;

        $defaultDays    = $this->saisonEnd->diffInDays($this->saisonStart);
        $days           = $until->diffInDays($from);

        $price = round($defaultPrice * $days / $defaultDays);
        return $price;
    }

    public function getWinterPrice($length, $width, Carbon $from = null, Carbon $until = null)
    {
        $defaultPrice = $this->getDefaultWinterPrice($length, $width);
        if(!$from && !$until) {
            return $defaultPrice;
        }
        $from   = !$from ? $this->winterStart : $from;
        $until  = !$until ? $this->winterEnd : $until;

        $defaultDays    = $this->winterEnd->diffInDays($this->winterStart);
        $days           = $until->diffInDays($from);

        $price = round($defaultPrice * $days / $defaultDays);
        return $price;
    }

    public function getDefaultSaisonPrice($length, $width)
    {
        return round($this->priceSaisonFactor * $length * $width);
    }

    public function getDefaultWinterPrice($length, $width)
    {
        return round($this->priceWinterFactor * $length * $width);
    }
}
