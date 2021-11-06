<?php

namespace App\Libs\Prices;

use App\Libs\Prices\Boat\Base;
use App\Libs\Prices\Boat\Cleaning;
use App\Libs\Prices\Boat\Crane;
use App\Libs\Prices\Boat\MastCrane;
use App\Libs\Prices\Boat\Individual;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BoatPrice extends PriceCalculator
{
    /**
     * @var int
     */
    protected static $priceBase = 0;
    protected static $priceCrane = 0;
    protected static $priceMastCrane = 0;
    protected static $priceCleaning = 0;
    protected static $modusDatePeriod;
    protected static $priceIndividual = 0;

    public function getPrice(Request $request): array
    {
        $useCrane       = $request->post('crane');
        $useMastCrane   = $request->post('mast_crane');
        $useCleaning    = $request->post('cleaning');
        $modus          = $request->post('modus');

        $length         = (int) $request->post('length', 0);
        $width          = (int) $request->post('width', 0);
        $weight         = (int) $request->post('weight', 0);
        $mastWeight     = (int) $request->post('mast_weight', 0);
        $specialPrice   = (int) $request->post('default_price', 0);

        if((!static::$from || !static::$until) && $modus) {
            $today          = Carbon::today();
            $year           = $today->format('Y');
            $nextYear       = $today->copy()->addYear()->format('Y');
            $saisonStart    = Carbon::make($year . '-' . config('port.prices.boat.saison_start'));
            $saisonEnd      = Carbon::make($year . '-' . config('port.prices.boat.saison_end'));
            $winterStart    = Carbon::make($year . '-' . config('port.prices.boat.winter_start'));
            $winterEnd      = Carbon::make($nextYear . '-' . config('port.prices.boat.winter_end'));

            switch ($modus) {
            case 'saison':
                static::$from   = $saisonStart;
                static::$until  = $saisonEnd;
                static::$_datePeriod = $saisonStart->toPeriod($saisonEnd)->toDatePeriod();
                static::$daysCount   = static::$_datePeriod->getDateInterval()->days;
                break;
            case 'winter':
            default:
                static::$from   = $winterStart;
                static::$until  = $winterEnd;
                static::$_datePeriod = $winterStart->toPeriod($winterEnd)->toDatePeriod();
                static::$daysCount   = static::$_datePeriod->getDateInterval()->days;
                break;
            }
        }

        $dCount     = static::$daysCount;
        $dPeriod    = static::$_datePeriod;
        $base       = new Base($modus, $length, $width);
        $crane      = new Crane($useCrane, $weight);
        $mastCrane  = new MastCrane($useMastCrane, $mastWeight);
        $cleaning   = new Cleaning($useCleaning, $length);
        $individual = new Individual($specialPrice);

        static::$modusDatePeriod    = $modus;
        static::$priceIndividual    = $individual->addPrice($specialPrice);
        static::$priceBase          = $base->setDaysCount($dCount)->addPrice($dPeriod);
        static::$priceCrane         = $crane->addPrice();
        static::$priceMastCrane     = $mastCrane->addPrice();
        static::$priceCleaning      = $cleaning->addPrice();
        static::$total = 0;

        $price = $this
            ->add(static::$priceBase)
            ->add(static::$priceCrane)
            ->add(static::$priceMastCrane)
            ->add(static::$priceCleaning)
            ->set(static::$priceIndividual);

        return $price->formatResult();
    }

}
