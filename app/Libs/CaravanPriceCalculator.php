<?php
namespace App\Libs;

use Carbon\Carbon;
use DatePeriod;

/**
 *
 */
class CaravanPriceCalculator extends PriceCalculator
{
    /**
     * @var int
     */
    protected $dailyPrice = 0;
    /**
     * @var int
     */
    protected $priceTotal = 0;
    /**
     * @var bool
     */
    protected $electric = false;
    /**
     * @var int
     */
    protected $electric_per_day = 0;
    /**
     * @var int
     */
    protected $sum_person_price = 0;
    /**
     * @var int
     */
    protected $persons = 0;
    /**
     * @var bool
     */
    protected $is_saison = false;
    /**
     * @var int
     */
    protected $car_length = 0;
    /**
     * @var int
     */
    protected $car_price_per_day = 0;

    /**
     * @param Carbon $from
     * @param Carbon $until
     * @param int $length
     * @param int $persons
     * @param bool $electric
     * @param int|null $dayPrice
     * @return array
     */
    public function getPrice(Carbon $from, Carbon $until, int $length, int $persons = 1, bool $electric = false, int $dayPrice = null) {
        $this->priceTotal = 0;
        $dates = $from->toPeriod($until)->toDatePeriod();
        $prices = [];
        foreach ( $dates as $day ) {
            $this->dailyPrice = 0;
            $prices[] = $this
                ->addDailyPersonsPrice($persons)
                ->addDailyElectricPrice($electric)
                ->addDailySaisonPriceByLength($day, $length)
                ->setDailyIndividualPrice($dayPrice)
                ->getDailyFormatedResult($day, $dayPrice)
            ;
            $this->priceTotal += $this->dailyPrice;
        }
        return ['total' => $this->priceTotal, 'prices' => $prices];
    }

    /**
     * @param $persons
     * @return $this
     */
    protected function addDailyPersonsPrice($persons)
    {
        $personsInclusive   = config('port.prices.caravan.persons_inclusivce');
        $personsAdditional  = config('port.prices.caravan.persons_additional');
        $this->persons = $persons;
        // add price per person exclusive
        if($persons > $personsInclusive) {
            $addPersons = $persons - $personsInclusive;
            $this->sum_person_price = $personsAdditional * $addPersons;
        }
        $this->dailyPrice += $this->sum_person_price;
        return $this;
    }

    /**
     * @param false $electric
     * @return $this
     */
    protected function addDailyElectricPrice($electric = false)
    {
        $electricPrice = config('port.prices.caravan.electric_per_day');
        $this->electric = $electric;
        if($this->electric) {
            $this->electric_per_day = $electricPrice;
            $this->dailyPrice += $electricPrice;
        }
        return $this;
    }

    /**
     * @param Carbon $date
     * @param $length
     * @return $this
     */
    protected function addDailySaisonPriceByLength(Carbon $date, $length)
    {
        $saisonFromMonth    = config('port.main.dates.saison.fromMonth');
        $saisonUntilMonth   = config('port.main.dates.saison.untilMonth');
        $defaultPricePerDay = config('port.prices.caravan.default_per_day');
        $saisonPricePerDay  = config('port.prices.caravan.saison_per_day');

        $this->car_length = $length;
        // saison
        if($date->month >= $saisonFromMonth && $date->month <= $saisonUntilMonth) {
            $this->is_saison = true;
            $price = isset($saisonPricePerDay[$length]) ? $saisonPricePerDay[$length] : 0;
        }
        // neben saison
        else
        {
            $this->is_saison = false;
            $price = isset($defaultPricePerDay[$length]) ? $defaultPricePerDay[$length] : 0;
        }

        $this->dailyPrice += $price;
        $this->car_price_per_day = $price;

        return $this;
    }

    /**
     * @param null $individualPrice
     * @return $this
     */
    protected function setDailyIndividualPrice($individualPrice = null)
    {
        if($individualPrice && $individualPrice > 0) {
            $this->dailyPrice = $individualPrice;
        }
        return $this;
    }

    /**
     * @param Carbon $date
     * @param null $indiviualPrice
     * @return array
     */
    protected function getDailyFormatedResult(Carbon $date, $indiviualPrice = null)
    {
        $data           = [];
        $dailyElectricPrice  = config('port.prices.caravan.electric_per_day');

        $data[$date->format('Y-m-d')] = [
            'date'              => $date->format('d.m.Y'),
            'persons'           => $this->persons,
            'sum_person_price'  => $this->sum_person_price,
            'electric_per_day'  => $this->electric ? $dailyElectricPrice : 0,
            'is_saison'         => $this->is_saison,
            'car_length'        => $this->car_length,
            'car_price_per_day' => $indiviualPrice ?? $this->car_price_per_day,
            'sum_price'         => $this->dailyPrice,
        ];

        return $data;
    }
}
