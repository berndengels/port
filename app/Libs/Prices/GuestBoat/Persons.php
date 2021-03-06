<?php
namespace App\Libs\Prices\GuestBoat;

use App\Libs\Prices\CaravanPrice;
use App\Libs\Prices\Price;
use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Persons extends Main implements IDailyPrice
{
    public function __construct(protected $persons = null)
    {
        $this->initConfig();
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        $value = 0;
        $pComponent = $this->priceComponents
            ->where('key','=', 'persons')
            ->first()
        ;
        $inclusive = $pComponent->unit_inclusive ?? 0;

        if($this->persons && (int) $this->persons > $inclusive) {
            $value = ($this->persons - $inclusive) * $this->daysCount * $pComponent->unit_price;
        }
        return new Price($value);
    }

    /**
     * @return int
     */
    public function getPersons(): int
    {
        return (int) $this->persons;
    }

    /**
     * @param  int $persons
     * @return Persons
     */
    public function setPersons(int $persons): Persons
    {
        $this->persons = $persons;
        return $this;
    }
}
