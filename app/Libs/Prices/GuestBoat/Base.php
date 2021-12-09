<?php
namespace App\Libs\Prices\GuestBoat;

use Carbon\Carbon;
use DatePeriod;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;
use App\Entities\SaisonDatesEntity;
use App\Repositories\ConfigSaisonDatesRepository;

class Base extends Main implements IDailyPrice
{
    public function __construct(
        protected Carbon $from,
        protected Carbon $until,
        protected float|int $length = 0
    )
    {
        $this->initConfig();
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        $repository = new ConfigSaisonDatesRepository($this->from, $this->until);
        $entities = $repository->getTouchedGuestSaisons($this->dateModel, $this->length);
        $entities->each(fn(SaisonDatesEntity $item) =>
            static::$dailyPrices += $item->getDailyPrices()->toArray()
        );
        ksort(static::$dailyPrices);
        $sumPrice = $entities->sum(fn(SaisonDatesEntity $i) => $i->getDailyPrices()->values()->sum());
        return new Price(value: $sumPrice);
    }
}
