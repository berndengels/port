<?php
namespace App\Libs\Prices\Boat;

use Carbon\Carbon;
use App\Models\Boat;
use App\Models\ConfigBoatPrice;
use App\Libs\Prices\MainPriceItem;
use Illuminate\Support\Collection;
use App\Models\ConfigPriceComponent;
use Illuminate\Database\Eloquent\Builder;

abstract class Main extends MainPriceItem
{
//    protected $dateModel = BoatDates::class;
    protected $model = Boat::class;

    /**
     * @var Carbon
     */
    protected static $saisonStart;
    /**
     * @var Carbon
     */
    protected static $saisonEnd;
    /**
     * @var Carbon
     */
    protected static $winterStart;
    /**
     * @var Carbon
     */
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
    protected $priceTransport;
    protected $priceMastCraneUpperWeight;
    /**
     * @var Collection
     */
    protected $priceComponents;
    /**
     * @var ConfigPriceComponent
     */

    protected function initConfig()
    {
        parent::__construct();
        $today      = Carbon::today();
        $year       = $today->format('Y');
        $nextYear   = $today->copy()->addYear()->format('Y');

        $boatPrices = ConfigBoatPrice::with('saison')
            ->whereHas('saison', fn(Builder $query) => $query->where('key','=','customer'))
            ->get()
        ;
        $winter = $boatPrices->filter(fn(ConfigBoatPrice $p) => $p->saison->mode === 'winter')->first();
        $summer = $boatPrices->filter(fn(ConfigBoatPrice $p) => $p->saison->mode === 'summer')->first();

        static::$saisonStart    = new Carbon($year . '-' . $summer->saison->from_month . '-' . $summer->saison->from_day);
        static::$saisonEnd      = new Carbon($year . '-' . $summer->saison->until_month . '-' . $summer->saison->until_day);
        static::$winterStart    = new Carbon($year . '-' . $winter->saison->from_month . '-' . $winter->saison->from_day);
        static::$winterEnd      = new Carbon($nextYear . '-' . $winter->saison->until_month . '-' . $winter->saison->until_day);

        $this->priceSaisonFactor      = $summer->price_factor;
        $this->priceWinterFactor      = $winter->price_factor;

        static::$saisonPeriod         = static::$saisonStart->toPeriod(static::$saisonEnd)->toDatePeriod();
        static::$winterPeriod         = static::$winterStart->toPeriod(static::$winterEnd)->toDatePeriod();

        $this->defaultSaisonDays      = static::$saisonEnd->diffInDays(static::$saisonStart);
        $this->defaultWinterDays      = static::$winterEnd->diffInDays(static::$winterStart);

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
    public function getPriceTransport()
    {
        return $this->priceTransport;
    }

    /**
     * @return mixed
     */
    public function getPriceMastCraneUpperWeight()
    {
        return $this->priceMastCraneUpperWeight;
    }
}
