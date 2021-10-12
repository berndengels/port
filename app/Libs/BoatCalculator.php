<?php
namespace App\Libs;

use App\Libs\Services\Crane;
use App\Libs\Services\CraneMast;
use App\Libs\Services\HighPressureCleaning;
use Carbon\Carbon;

class BoatCalculator extends PriceCalculator
{
    use Crane, CraneMast, HighPressureCleaning;
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

    public function getSaisonPriceTotal($length, $width, $weight, Carbon $from = null, Carbon $until = null) {

    }

    public function getWinterPriceTotal($length, $width, $weight, Carbon $from = null, Carbon $until = null) {

    }

    public function getSaisonPrice($length, $width, $weight, Carbon $from = null, Carbon $until = null)
    {
        $defaultPrice = $this->getDefaultSaisonPrice($length, $width);
        if(!$from && !$until) {
            return $defaultPrice;
        }
        $from   = !$from ? $this->saisonStart : $from;
        $until  = !$until ? $this->saisonEnd : $until;

        $defaultDays    = $this->getDefaultSaisonDays();
        $days           = $until->diffInDays($from);

        $price = round($defaultPrice * $days / $defaultDays);
        return $price;
    }

    public function getWinterPrice($length, $width, $weight, Carbon $from = null, Carbon $until = null)
    {
        $defaultPrice = $this->getDefaultWinterPrice($length, $width);
        if(!$from && !$until) {
            return $defaultPrice;
        }
        $from   = !$from ? $this->winterStart : $from;
        $until  = !$until ? $this->winterEnd : $until;

        $defaultDays    = $this->getDefaultWinterDays();
        $days           = $until->diffInDays($from);

        $price = round($defaultPrice * $days / $defaultDays);
        return $price;
    }

    private function getDefaultSaisonDays() {
        return $this->saisonEnd->diffInDays($this->saisonStart);
    }

    private function getDefaultWinterDays() {
        return $this->winterEnd->diffInDays($this->winterStart);
    }

    private function getDefaultSaisonPrice($length, $width)
    {
        return round($this->priceSaisonFactor * $length * $width);
    }

    private function getDefaultWinterPrice($length, $width)
    {
        return round($this->priceWinterFactor * $length * $width);
    }
}
