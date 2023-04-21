<?php

namespace App\Traits\Models;


trait HasTaxRate
{
    public static function nettoPrice(int|float $bruttoPrice):float|int
    {
        $settings = config('settings');
        if(!$settings || !$settings->use_tax || 0 === $settings->tax || !$settings->tax) {
            return $bruttoPrice;
        }

        return round($bruttoPrice / (1 + $settings->tax / 100), 2);
    }

    public static function nettoPriceRounded(int|float $bruttoPrice):int
    {
        return round(self::nettoPrice($bruttoPrice), 2);
    }
}
