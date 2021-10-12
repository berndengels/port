<?php
namespace App\Libs\Services;

trait Crane
{
    public function getCranePrice(int $weightInKilo): int {
        $pricePerTon = (int) config('port.prices.boat.crane_per_ton') / 1000;
        $price = round($pricePerTon * $weightInKilo);
        return $price;
    }
}
