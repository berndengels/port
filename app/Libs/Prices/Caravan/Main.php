<?php

namespace App\Libs\Prices\Caravan;

use App\Models\Caravan;
use App\Libs\Prices\MainPriceItem;

abstract class Main extends MainPriceItem
{
    protected $model = Caravan::class;

    protected function initConfg()
    {
        parent::__construct();
        return $this;
    }
}
