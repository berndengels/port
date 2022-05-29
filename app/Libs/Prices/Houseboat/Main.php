<?php

namespace App\Libs\Prices\Houseboat;

use App\Models\Houseboat;
use App\Models\HouseboatDates;
use App\Libs\Prices\MainPriceItem;
use App\Models\ConfigPriceComponent;

abstract class Main extends MainPriceItem
{
    protected $dateModel = HouseboatDates::class;
    protected $model = Houseboat::class;


    /**
     * @var ConfigPriceComponent
     */
    protected $priceComponents;

    protected function initConfig()
    {
        return $this;
    }
}
