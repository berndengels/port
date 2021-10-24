<?php
namespace App\Libs\Prices\BoatGuest;

use App\Libs\Prices\CaravanPrice;
use DatePeriod;
use App\Libs\Prices\IDailyPrice;

class Persons extends Main implements IDailyPrice
{
    public function __construct(int $persons = 0)
    {
        $this->initConfig();
        $this->persons = $persons;
    }

    public function addPrice(DatePeriod $days)
    {

        if($this->persons > $this->personsInclusive) {
            return ($this->persons - $this->personsInclusive) * $this->personsAdditional;
        }
        return 0;
    }

    /**
     * @return int
     */
    public function getPersons(): int
    {
        return $this->persons;
    }

    /**
     * @param int $persons
     * @return Persons
     */
    public function setPersons(int $persons): Persons
    {
        $this->persons = $persons;
        return $this;
    }
}
