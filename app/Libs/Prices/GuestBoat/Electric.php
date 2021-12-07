<?php
namespace App\Libs\Prices\GuestBoat;

use App\Libs\Prices\CaravanPrice;
use App\Libs\Prices\Price;
use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Electric extends Main implements IDailyPrice
{
    public function __construct(protected bool $electric)
    {
        $this->initConfig();
    }

    public function addPrice(DatePeriod $days): Price
    {
        $value = 0;
        if($this->electric) {
            $unitPrice = $this->priceComponents
                ->where('key','=', 'electric')
                ->first()
                ->unit_price
            ;
            $value = $this->daysCount * $unitPrice;
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
