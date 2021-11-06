<?php
namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\Price;
use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Persons extends Main implements IDailyPrice
{
    public function __construct(protected int $persons = 0)
    {
        $this->initConfg();
    }

    public function addPrice(DatePeriod $days): Price
    {
        $value = 0;
        if($this->persons > $this->personsInclusive) {
            $value = ($this->persons - $this->personsInclusive) * $this->daysCount * $this->personsAdditional;
        }
        return new Price($value);
    }

    /**
     * @return int
     */
    public function getPersons(): int
    {
        return $this->persons;
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
