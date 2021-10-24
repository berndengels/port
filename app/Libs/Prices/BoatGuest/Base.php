<?php
namespace App\Libs\Prices\BoatGuest;

use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Base extends Main implements IDailyPrice
{
    public function __construct(int $length)
    {
        $this->initConfig();
        $this->length = $length;
    }

    public function addPrice(DatePeriod $days)
    {
        return iterator_count($days) * $this->length * $this->pricePerMeter;
    }
}
