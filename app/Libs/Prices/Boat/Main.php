<?php

namespace App\Libs\Prices\Boat;

use App\Libs\Prices\MainPriceItem;
use Carbon\Carbon;

abstract class Main extends MainPriceItem
{
    protected $priceSaisonFactor;
    protected $priceWinterFactor;
    protected $pricePerTon;
    protected $saisonStart;
    protected $saisonEnd;
    protected $winterStart;
    protected $winterEnd;
    protected $defaultSaisonDays;
    protected $defaultWinterDays;
    protected $defaultSaisonPrice;
    protected $defaultWinterPrice;
    protected $priceCleaningPerLength;
    protected $priceMastCrane;
    protected $priceMastCraneUpperWeight;

    protected function initConfig()
    {
        $today          = Carbon::today();
        $year           = $today->format('Y');
        $nextYear       = $today->copy()->addYear()->format('Y');
        $this->priceSaisonFactor    = config('port.prices.boat.price_saison_factor');
        $this->priceWinterFactor    = config('port.prices.boat.price_winter_factor');
        $this->saisonStart          = Carbon::make($year . '-' . config('port.prices.boat.saison_start'));
        $this->saisonEnd            = Carbon::make($year . '-' . config('port.prices.boat.saison_end'));
        $this->winterStart          = Carbon::make($year . '-' . config('port.prices.boat.winter_start'));
        $this->winterEnd            = Carbon::make($nextYear . '-' . config('port.prices.boat.winter_end'));
        $this->defaultSaisonDays    = $this->saisonEnd->diffInDays($this->saisonStart);
        $this->defaultWinterDays    = $this->winterEnd->diffInDays($this->winterStart);
        $this->pricePerTon          = (int) config('port.prices.boat.crane_per_ton');
        $this->priceCleaningPerLength       = config('port.prices.boat.cleaning_per_length');
        $this->priceMastCrane               = (int) config('port.prices.boat.mast_crane');
        $this->priceMastCraneUpperWeight    = (int) config('port.prices.boat.mast_crane_upper_per_100kg');
    }
}
