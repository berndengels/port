<?php

namespace App\Libs\Prices\GuestBoat;

use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use App\Libs\Prices\MainPriceItem;

abstract class Main extends MainPriceItem
{
    protected $dateModel = GuestBoatDates::class;
    protected $model = GuestBoat::class;

    protected function initConfig()
    {
        parent::__construct();
        return $this;
    }
}
