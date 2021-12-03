<?php

namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\MainPriceItem;
use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Models\ConfigPriceComponent;
use Carbon\Carbon;

abstract class Main extends MainPriceItem
{
    public static $dailyPrices = [];

    protected $dateModel = CaravanDates::class;
    protected $model = Caravan::class;

    protected $saisonFromMonth;
    protected $saisonUntilMonth;
    protected $defaultPricePerDay;
    protected $saisonPricePerDay;

//    protected $configs = [];
//    protected $params = [];

    protected $priceElectricPerDay;
    protected $personsInclusive = 0;
    protected $personsAdditional = 0;

    protected function initConfg()
    {
        $this->saisonFromMonth      = config('port.main.dates.saison.fromMonth');
        $this->saisonUntilMonth     = config('port.main.dates.saison.untilMonth');
        $this->defaultPricePerDay   = config('port.prices.caravan.default_per_day');
        $this->saisonPricePerDay    = config('port.prices.caravan.saison_per_day');
        $this->priceElectricPerDay  = config('port.prices.caravan.electric_per_day');
        $this->personsInclusive     = config('port.prices.caravan.persons_inclusivce');
        $this->personsAdditional    = config('port.prices.caravan.persons_additional');
    }

    /**
     * @param Carbon $from
     * @return Main
     */
    public function setFrom(Carbon $from): Main
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param Carbon $until
     * @return Main
     */
    public function setUntil(Carbon $until): Main
    {
        $this->until = $until;
        return $this;
    }
}
