<?php
namespace App\Libs\Services;

trait HighPressureCleaning
{
    public function getHighPressureCleaningPrice(): int {
        $price = (int) config('port.prices.boat.high_pressure_cleaning');
        return $price;
    }
}
