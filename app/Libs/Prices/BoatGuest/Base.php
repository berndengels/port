<?php
namespace App\Libs\Prices\BoatGuest;

use App\Libs\Prices\Price;
use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Base extends Main implements IDailyPrice
{
    public function __construct(protected int $length)
    {
        $this->initConfig();
    }

    public function addPrice(DatePeriod $days): Price
    {
        return new Price(value: $this->daysCount * $this->length * $this->pricePerMeter);
    }
}
