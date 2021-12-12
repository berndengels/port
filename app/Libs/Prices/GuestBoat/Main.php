<?php

namespace App\Libs\Prices\GuestBoat;

use App\Models\ConfigEntityType;
use App\Models\ConfigPriceComponent;
use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use App\Libs\Prices\MainPriceItem;
use Illuminate\Support\Str;

abstract class Main extends MainPriceItem
{
    protected $dateModel = GuestBoatDates::class;
    protected $model = GuestBoat::class;
    /**
     * @var ConfigPriceComponent
     */
    protected $priceComponents;

    protected function initConfig()
    {
        $this->priceComponents = ConfigEntityType::whereModel($this->model)
            ->first()
            ->priceComponents
            ->keyBy(fn(ConfigPriceComponent $c) => 'price' . ucfirst(Str::camel($c->key)))
        ;
    }
}
