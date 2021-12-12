<?php

namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\MainPriceItem;
use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Models\ConfigEntityType;
use App\Models\ConfigPriceComponent;
use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class Main extends MainPriceItem
{
    protected $dateModel = CaravanDates::class;
    protected $model = Caravan::class;
    /**
     * @var ConfigPriceComponent
     */
    protected $priceComponents;

    protected function initConfg()
    {
        $this->priceComponents = ConfigEntityType::whereModel($this->model)
            ->first()
            ->priceComponents
            ->keyBy(fn(ConfigPriceComponent $c) => 'price' . ucfirst(Str::camel($c->key)))
        ;
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
