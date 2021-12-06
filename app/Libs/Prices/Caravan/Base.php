<?php
namespace App\Libs\Prices\Caravan;

use App\Entities\SaisonDatesEntity;
use App\Models\ConfigDailyPrice;
use App\Models\ConfigEntityType;
use App\Models\ConfigPriceComponent;
use App\Models\ConfigSaisonDates;
use DatePeriod;
use Carbon\Carbon;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Visualizer;
use App\Repositories\ConfigSaisonDatesRepository;

class Base extends Main implements IDailyPrice
{
    /**
     * @var ConfigSaisonDatesRepository
     */
    protected $saisonDatesRepository;

    public function __construct(protected Carbon $from, protected Carbon $until, protected int $carlength = 0)
    {
        $this->initConfg();
    }

    public function addPrice(DatePeriod $days): Price
    {
        $this->saisonDatesRepository = new ConfigSaisonDatesRepository();
        $entities = $this->saisonDatesRepository->getTouchedSaisons($this->from, $this->until, $this->dateModel, $this->carlength);
        $entities->each(fn(SaisonDatesEntity $item) => static::$dailyPrices += $item->getDailyPrices()->toArray());
        $sumPrice = $entities->sum(fn(SaisonDatesEntity $i) => $i->getDailyPrices()->values()->sum());

        return new Price(value: $sumPrice);
    }

    /**
     * @return int
     */
    public function getCarlength(): int
    {
        return $this->carlength;
    }

    /**
     * @param  int $carlength
     * @return Base
     */
    public function setCarlength(int $carlength): Base
    {
        $this->carlength = $carlength;
        return $this;
    }
}
