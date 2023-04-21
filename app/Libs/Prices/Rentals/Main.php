<?php

namespace App\Libs\Prices\Rentals;

use App\Libs\Prices\MainPriceItem;

abstract class Main extends MainPriceItem
{
    protected $model;

    protected function initConfg()
    {
        parent::__construct();
        return $this;
    }
}
