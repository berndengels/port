<?php
namespace App\Libs\Services;

trait CraneMast
{
    public function getCraneMastPrice() : int {
        $price = (int) config('port.prices.boat.mast_crane');
        return $price;
    }
}
