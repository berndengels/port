<?php
namespace App\Libs\Prices\Caravan;

use DatePeriod;
use App\Libs\Prices\Price;
use App\Libs\Prices\IDailyPrice;

class Persons extends Main implements IDailyPrice
{
    public function __construct(
        protected ?int $persons = 0
    )
    {
        $this->initConfg();
    }

    public function addPrice(?DatePeriod $days = null): Price
    {
        $value = 0;
        if($this->persons && $this->persons > 0) {
            if($this->unitInclusive) {
                if((int)$this->persons > (int)$this->unitInclusive) {
                    $value = ((int)$this->persons - (int)$this->unitInclusive) * $this->daysCount * $this->unitPrice;
                } else {
                    $value = 0;
                }
            } else {
                $value = (int)$this->persons * $this->daysCount * $this->unitPrice;
            }
        }
        return new Price($value);
    }

    /**
     * @return int
     */
/*
    public function getPersons(): int
    {
        return $this->persons;
    }
*/
    /**
     * @param  int $persons
     * @return Persons
     */
/*
    public function setPersons(int $persons): Persons
    {
        $this->persons = $persons;
        return $this;
    }
*/
}
