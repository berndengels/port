<?php
namespace App\Libs;

use Carbon\Carbon;
use DatePeriod;

class CaravanPriceCalculator extends PriceCalculator
{
    protected $dailyPrice = 0;
    protected $priceTotal = 0;
    protected $electric = false;
    protected $electric_per_day = 0;
    protected $sum_person_price = 0;
    protected $persons = 0;
    protected $is_saison = false;
    protected $car_length = 0;
    protected $car_price_per_day = 0;

    public function getPrice(Carbon $from, Carbon $until, int $length, int $persons = 1, bool $electric = false, int $dayPrice = null) {
        $this->priceTotal = 0;
        $dates  = $from->toPeriod($until)->toDatePeriod();
        foreach ( $dates as $day ) {
            $this->dailyPrice = 0;
            $result = $this
                ->addDailyPersonsPrice($persons)
                ->addDailyElectricPrice($electric)
                ->addDailySaisonPriceByLength($day, $length)
                ->setDailyIndividualPrice($dayPrice)
                ->getDailyFormatedResult($day, $dayPrice)
            ;
            $this->priceTotal += $this->dailyPrice;
        }
        return ['total' => $this->priceTotal, 'prices' => $result];
    }

    protected function addDailyPersonsPrice($persons)
    {
        $personsInclusive   = config('port.main.prices.caravan.persons_inclusivce');
        $personsAdditional  = config('port.main.prices.caravan.persons_additional');
        $this->persons = $persons;
        // add price per person exclusive
        if($persons > $personsInclusive) {
            $addPersons = $persons - $personsInclusive;
            $this->sum_person_price = $personsAdditional * $addPersons;
        }
        $this->dailyPrice += $this->sum_person_price;
        return $this;
    }

    protected function addDailyElectricPrice($electric = false)
    {
        $electricPrice = config('port.main.prices.caravan.electric_per_day');
        $this->electric = $electric;
        if($this->electric) {
            $this->electric_per_day = $electricPrice;
            $this->dailyPrice += $electricPrice;
        }
        return $this;
    }

    protected function addDailySaisonPriceByLength(Carbon $date, $length)
    {
        $saisonFromMonth    = config('port.main.dates.saison.fromMonth');
        $saisonUntilMonth   = config('port.main.dates.saison.untilMonth');
        $defaultPricePerDay = config('port.main.prices.caravan.default_per_day');
        $saisonPricePerDay  = config('port.main.prices.caravan.saison_per_day');

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

    protected function setDailyIndividualPrice($individualPrice = null)
    {
        if($individualPrice && $individualPrice > 0) {
            $this->dailyPrice = $individualPrice;
        }
        return $this;
    }

    protected function getDailyFormatedResult(Carbon $date, $indiviualPrice = null)
    {
        $data           = [];
        $dailyElectricPrice  = config('port.main.prices.caravan.electric_per_day');

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
