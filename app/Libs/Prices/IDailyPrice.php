<?php
namespace App\Libs\Prices;

use DatePeriod;

interface IDailyPrice
{
    public function addPrice(?DatePeriod $days = null): Price;
}
