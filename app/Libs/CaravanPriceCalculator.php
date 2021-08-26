<?php
namespace App\Libs;

use Carbon\Carbon;

class CaravanPriceCalculator extends PriceCalculator
{
    public function getPrice(Carbon $from, Carbon $until, int $length, int $persons = 1, bool $electric = false) {
        $countDays = $from->diffInDays($until);

        $total                  = 0;
        $configSaisonFromMonth  = config('port.dates.saison.fromMonth');
        $configSaisonUntilMonth = config('port.dates.saison.untilMonth');

        $configPersonsPrice     = config('port.prices.caravan.per_persons');
        $configElectricPrice    = config('port.prices.caravan.electric_per_day');
        $configShortLength      = config('port.prices.caravan.shortLength');
        if($length <= $configShortLength) {
            $configLength = config('port.prices.caravan.length.short');
        } else {
            $configLength = config('port.prices.caravan.length.long');
        }
        $days       = [];
        $current    = $from->copy();
        $i = 0;

        while ($i <= $countDays) {
            if(0 === $i) {
                $day = $current;
            } else {
                $day = $current->addDay();
            }
            $sumPersonsPrice = $configPersonsPrice * $persons;
            $price = $configPersonsPrice * $persons;
            if($electric) {
                $price += $configElectricPrice;
            }
            if($day->month >= $configSaisonFromMonth && $day->month <= $configSaisonUntilMonth) {
                $carPricePerDay = $configLength['saison']['per_day'];
            } else {
                $carPricePerDay = $configLength['default']['per_day'];
            }
            $price += $carPricePerDay;
            $total += $price;
            $days[$day->format('Y-m-d')] = [
                'date'              => $day->format('d.m.Y'),
                'persons'           => $persons,
                'price_per_person'  => $configPersonsPrice,
                'sum_person_price'  => $sumPersonsPrice,
                'electric_per_day'  => $electric ? $configElectricPrice : 0,
                'is_saison'         => (int) ($day->month >= $configSaisonFromMonth && $day->month <= $configSaisonUntilMonth),
                'car_length'        => $length,
                'car_price_per_day' => $carPricePerDay,
                'sum_price'         => $price,
            ];
            $i++;
        }

        return ['total' => $total, 'prices' => $days];
    }
}
