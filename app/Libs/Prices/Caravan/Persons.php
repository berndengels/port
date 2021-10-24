<?php
namespace App\Libs\Prices\Caravan;

use App\Libs\Prices\CaravanPrice;
use DatePeriod;
use App\Libs\Prices\IPrice;

class Persons implements IPrice
{
    /**
     * @var int
     */
    protected $persons = 0;

    public function __construct(int $persons = 0)
    {
        $this->persons = $persons;
    }

    public function addPrice(DatePeriod $days)
    {
        $personsInclusive   = config('port.prices.caravan.persons_inclusivce');
        $personsAdditionalPerDay  = config('port.prices.caravan.persons_additional');

        if($this->persons > $personsInclusive) {
            return ($this->persons - $personsInclusive) * $personsAdditionalPerDay;
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
