<?php
namespace App\Libs\Prices\Caravan;

use DatePeriod;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;

class Electric extends Main implements IDailyPrice
{


    public function __construct(protected bool $electric)
    {
        $this->initConfg();
    }

    public function addPrice(DatePeriod $days): Price
    {
        $value = 0;
        if($this->electric) {
            $value = $this->daysCount * $this->priceElectricPerDay;
        }
        return new Price($value);
    }

    /**
     * @return bool
     */
    public function isElectric(): bool
    {
        return $this->electric;
    }

    /**
     * @param  bool $electric
     * @return Electric
     */
    public function setElectric(bool $electric): Electric
    {
        $this->electric = $electric;
        return $this;
    }
}
