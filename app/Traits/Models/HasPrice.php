<?php

namespace App\Traits\Models;

use App\Models\Priceable;

trait HasPrice
{
    public function getPriceDataAttribute()
    {
        return json_decode($this->prices);
    }
}
