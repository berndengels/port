<?php
namespace App\Libs\Prices\Boat;

use Carbon\Carbon;
use App\Libs\Prices\MainPriceItem;

abstract class Main extends MainPriceItem
{
    protected static $saisonStart;
    protected static $saisonEnd;
    protected static $winterStart;
    protected static $winterEnd;
    protected static $saisonPeriod;
    protected static $winterPeriod;

    protected $priceSaisonFactor;
    protected $priceWinterFactor;
    protected $pricePerTon;
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
        $this->priceSaisonFactor      = config('port.prices.boat.price_saison_factor');
        $this->priceWinterFactor      = config('port.prices.boat.price_winter_factor');

        static::$saisonStart          = Carbon::make($year . '-' . config('port.prices.boat.saison_start'));
        static::$saisonEnd            = Carbon::make($year . '-' . config('port.prices.boat.saison_end'));
        static::$winterStart          = Carbon::make($year . '-' . config('port.prices.boat.winter_start'));
        static::$winterEnd            = Carbon::make($nextYear . '-' . config('port.prices.boat.winter_end'));
        static::$saisonPeriod         = static::$saisonStart->toPeriod(static::$saisonEnd)->toDatePeriod();
        static::$winterPeriod         = static::$winterStart->toPeriod(static::$winterEnd)->toDatePeriod();
        $this->defaultSaisonDays      = static::$saisonEnd->diffInDays(static::$saisonStart);
        $this->defaultWinterDays      = static::$winterEnd->diffInDays(static::$winterStart);

        $this->pricePerTon            = (int) config('port.prices.boat.crane_per_ton');
        $this->priceCleaningPerLength = config('port.prices.boat.cleaning_per_length');
        $this->priceMastCrane               = (int) config('port.prices.boat.mast_crane');
        $this->priceMastCraneUpperWeight    = (int) config('port.prices.boat.mast_crane_upper_per_100kg');

        return $this;
    }

    /**
     * @return mixed
     */
    public static function getSaisonStart()
    {
        return self::$saisonStart;
    }

    /**
     * @return mixed
     */
    public static function getSaisonEnd()
    {
        return self::$saisonEnd;
    }

    /**
     * @return mixed
     */
    public static function getWinterStart()
    {
        return self::$winterStart;
    }

    /**
     * @return mixed
     */
    public static function getWinterEnd()
    {
        return self::$winterEnd;
    }

    /**
     * @return mixed
     */
    public static function getSaisonPeriod()
    {
        return self::$saisonPeriod;
    }

    /**
     * @return mixed
     */
    public static function getWinterPeriod()
    {
        return self::$winterPeriod;
    }

    /**
     * @return mixed
     */
    public function getPriceSaisonFactor()
    {
        return $this->priceSaisonFactor;
    }

    /**
     * @return mixed
     */
    public function getPriceWinterFactor()
    {
        return $this->priceWinterFactor;
    }

    /**
     * @return mixed
     */
    public function getPricePerTon()
    {
        return $this->pricePerTon;
    }

    /**
     * @return mixed
     */
    public function getDefaultSaisonDays()
    {
        return $this->defaultSaisonDays;
    }

    /**
     * @return mixed
     */
    public function getDefaultWinterDays()
    {
        return $this->defaultWinterDays;
    }

    /**
     * @return mixed
     */
    public function getDefaultSaisonPrice()
    {
        return $this->defaultSaisonPrice;
    }

    /**
     * @return mixed
     */
    public function getDefaultWinterPrice()
    {
        return $this->defaultWinterPrice;
    }

    /**
     * @return mixed
     */
    public function getPriceCleaningPerLength()
    {
        return $this->priceCleaningPerLength;
    }

    /**
     * @return mixed
     */
    public function getPriceMastCrane()
    {
        return $this->priceMastCrane;
    }

    /**
     * @return mixed
     */
    public function getPriceMastCraneUpperWeight()
    {
        return $this->priceMastCraneUpperWeight;
    }
}
