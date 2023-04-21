<?php
namespace App\Libs\Prices\GuestBoat;

use App\Models\Berth;
use DatePeriod;
use Carbon\Carbon;
use App\Models\GuestBoatDates;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;
use App\Entities\SaisonDatesEntity;
use App\Repositories\ConfigSaisonDatesRepository;

class Base extends Main implements IDailyPrice
{
    public static $dailyPrices;

    public function __construct(
        protected Carbon $from,
        protected Carbon $until,
        protected int $berth_id,
        protected float|int $length = 0
    )
    {
        $this->initConfig();
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        $berth = Berth::find($this->berth_id);
        if($berth->daily_price > 0) {
            $countDays = iterator_count($days);
            $sumPrice = $berth->daily_price * $countDays;
        }
        else {
            static::$dailyPrices = [];
            $repository = new ConfigSaisonDatesRepository($this->from, $this->until);
            $entities = $repository->getTouchedGuestSaisons($this->dateModel, $this->length);
            $entities->each(fn(SaisonDatesEntity $item) => static::$dailyPrices += $item->getDailyPrices()->toArray());
            ksort(static::$dailyPrices, SORT_NATURAL);
            $sumPrice = $entities->sum(fn(SaisonDatesEntity $i) => $i->getDailyPrices()->pluck('price')->values()->sum());
        }

        return new Price(value: $sumPrice);
    }

    /**
     * @return float|int
     */
    public function getLength(): float|int
    {
        return $this->length;
    }

    /**
     * @param float|int $length
     * @return Base
     */
    public function setLength(float|int $length): Base
    {
        $this->length = $length;
        return $this;
    }
}
