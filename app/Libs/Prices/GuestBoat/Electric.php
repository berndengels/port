<?php
namespace App\Libs\Prices\GuestBoat;

use App\Libs\Prices\CaravanPrice;
use App\Libs\Prices\Price;
use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Electric extends Main implements IDailyPrice
{
    public function __construct(protected bool $electric = false)
    {
        $this->initConfig();
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        $value = 0;
        if(true === $this->electric) {
            $value = $this->daysCount * $this->unitPrice;
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
