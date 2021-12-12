<?php

namespace App\Traits\Models;

trait HasTaxRate
{
    public function nettoPrice(int|float $bruttoPrice): float
    {
        if($this->taxRate() > 0) {
            return round($bruttoPrice / (1 + ($this->taxRate()/100)), 2);
        }
    }

    public function taxRate(): float
    {
        return config('port.prices.tax.rate');
    }
}
