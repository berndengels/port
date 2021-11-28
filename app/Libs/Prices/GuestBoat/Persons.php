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

    public function addPrice(DatePeriod $days): Price
    {
        $value = 0;
        if($this->persons && (int) $this->persons > $this->personsInclusive) {
            $value = ($this->persons - $this->personsInclusive) * $this->daysCount * $this->personsAdditional;
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
