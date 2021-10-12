<?php
namespace App\Libs;

use Carbon\Carbon;

class  BoatCalculator extends PriceCalculator
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

    protected $modus;
    protected $from;
    protected $until;

    /**
     * @var int
     */
    protected $crane = 0;
    /**
     * @var int
     */
    protected $mastCrane = 0;
    /**
     * @var int
     */
    protected $cleaning = 0;
    /**
     * @var int
     */
    protected $price = 0;
    /**
     * @var int
     */
    protected $priceTotal = 0;

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

        $this->priceCranePerTon = (int) config('port.prices.boat.crane_per_ton') / 1000;
        $this->priceMastCrane   = (int) config('port.prices.boat.mast_crane');
        $this->priceCleaning    = (int) config('port.prices.boat.high_pressure_cleaning');
    }

    public function getPrice($modus, $length, $width, $weight, $crane, $mastCrane, $cleaning, Carbon $from = null, Carbon $until = null, $individualPrice = null)
    {
        $this->modus = $modus;

        if($modus === 'saison') {
            $result = $this
                ->setSaisonPrice($length, $width, $from, $until)
                ->setCranePrice($weight, $crane)
                ->setCraneMastPrice($mastCrane)
                ->setCleaningPrice($cleaning)
                ->getFormatedResult($individualPrice)
            ;
        } else {
            $result = $this
                ->setWinterPrice($length, $width, $from, $until)
                ->setCranePrice($weight, $crane)
                ->setCraneMastPrice($mastCrane)
                ->setCleaningPrice($cleaning)
                ->getFormatedResult($individualPrice)
            ;
        }
        return ['total' => $this->priceTotal, 'prices' => $result];
    }

    public function setSaisonPrice($length, $width, Carbon $from = null, Carbon $until = null)
    {
        $defaultPrice = $this->getDefaultSaisonPrice($length, $width);
        if(!$from && !$until) {
            $this->priceTotal += $this->price = $defaultPrice;
            return $this;
        }
        $from   = !$from ? $this->saisonStart : $from;
        $until  = !$until ? $this->saisonEnd : $until;

        $defaultDays    = $this->getDefaultSaisonDays();
        $days           = $until->diffInDays($from);

        $this->priceTotal += $this->price = round($defaultPrice * $days / $defaultDays);
        return $this;
    }

    public function setWinterPrice($length, $width, Carbon $from = null, Carbon $until = null)
    {
        $defaultPrice = $this->getDefaultWinterPrice($length, $width);
        if(!$from && !$until) {
            $this->priceTotal += $this->price = $defaultPrice;
            return $this;
        }
        $from   = !$from ? $this->winterStart : $from;
        $until  = !$until ? $this->winterEnd : $until;

        $defaultDays    = $this->getDefaultWinterDays();
        $days           = $until->diffInDays($from);

        $this->priceTotal += $this->price = round($defaultPrice * $days / $defaultDays);
        return $this;
    }

    private function getDefaultSaisonDays()
    {
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

    private function setCranePrice(int $weightInKilo, $crane = false) : self {
        if($crane) {
            $this->priceTotal += $this->crane = round($this->priceCranePerTon * $weightInKilo);
        }
        return $this;
    }

    public function setCraneMastPrice($mastCrane = false) : self {
        if($mastCrane) {
            $this->priceTotal += $this->mastCrane = $this->priceMastCrane;
        }
        return $this;
    }

    public function setCleaningPrice($cleaning = false) : self {
        if($cleaning) {
            $this->priceTotal += $this->cleaning = $this->priceCleaning;
        }
        return $this;
    }

    protected function getFormatedResult($individualPrice = null)
    {
        $data = [
            'modus'             => $this->modus,
            'crane'             => $individualPrice ? 0 : $this->crane,
            'mast_crane'        => $individualPrice ? 0 : $this->mastCrane,
            'cleaning'          => $individualPrice ? 0 : $this->cleaning,
            'price'             => $individualPrice ? 0 : $this->price,
            'sum_price'         => $individualPrice ?: $this->priceTotal,
        ];

        return $data;
    }
}
