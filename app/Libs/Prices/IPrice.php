<?php

namespace App\Libs\Prices;

use DatePeriod;

interface IPrice
{
    public function addPrice(DatePeriod $days);
}
