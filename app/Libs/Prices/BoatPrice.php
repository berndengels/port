<?php

namespace App\Libs\Prices;

use App\Libs\Prices\Boat\Base;
use App\Libs\Prices\Boat\Cleaning;
use App\Libs\Prices\Boat\Crane;
use App\Libs\Prices\Boat\MastCrane;
use App\Libs\Prices\Boat\Individual;
use App\Models\Boat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BoatPrice extends PriceCalculator
{
    /**
     * @var int
     */
    protected static $priceBase = 0;
    protected static $priceCrane = 0;
    protected static $priceMastCrane = 0;
    protected static $priceCleaning = 0;
    protected static $priceIndividual = 0;
    protected static $modusDatePeriod;


    public function params(): Collection
    {
        return collect([
            'crane',
            'mast_crane',
            'cleaning',
            'modus',
            'individual',
            'length',
            'width',
            'weight',
            'boat_type',
            'board_height',
            'mast_length',
            'mast_weight',
            'draft',
            'length_waterline',
            'length_keel',
        ]);
    }

    protected function registerAddPriceClasses(): Collection
    {
        return collect([
            Base::class,
            Crane::class,
            MastCrane::class,
            Cleaning::class,
        ]);
    }

    protected function registerSetPriceClasses(): Collection
    {
        return collect([
            Individual::class,
        ]);
    }

    public function getPrice(Request $request): array
    {
        $this->calculateDateMode($request);
        return parent::getPrice($request);
    }

    protected function calculateDateMode(Request $request) {
        $modus = $request->post('modus');
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
    }
}
