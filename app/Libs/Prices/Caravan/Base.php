<?php
namespace App\Libs\Prices\Caravan;

use App\Models\CaravanDates;
use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;
use App\Entities\SaisonDatesEntity;
use App\Repositories\ConfigSaisonDatesRepository;

class Base extends Main implements IDailyPrice
{
    public static $dailyPrices;
    protected $dateModel = CaravanDates::class;

    public function __construct(
        protected Carbon $from,
        protected Carbon $until,
        protected float|int $carlength = 0
    )
    {
        $this->initConfg();
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        static::$dailyPrices = [];
        $repository = new ConfigSaisonDatesRepository($this->from, $this->until);
        $entities = $repository->getTouchedGuestSaisons($this->dateModel, $this->carlength);
        $entities->each(fn(SaisonDatesEntity $item) => static::$dailyPrices += $item->getDailyPrices()->toArray());
        ksort(static::$dailyPrices,  SORT_NATURAL);
        $sumPrice = $entities->sum(fn(SaisonDatesEntity $i) => $i->getDailyPrices()->pluck('price')->values()->sum());

        return new Price(value: $sumPrice);
    }

    /**
     * @return int
     */
/*
    public function getCarlength(): float|int
    {
        return $this->carlength;
    }
*/
    /**
     * @param  int $carlength
     * @return Base
     */
/*
    public function setCarlength(float|int $carlength): Base
    {
        $this->carlength = $carlength;
        return $this;
    }
*/
}
