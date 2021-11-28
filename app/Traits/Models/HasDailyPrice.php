<?php

namespace App\Traits\Models;

use App\Models\DailyPrice;
use Illuminate\Database\Eloquent\Builder;

trait HasDailyPrice
{
    /**
     * Get all of the models's translations.
     *
     * @return Builder
     */
    public function dailyPrices()
    {
        return $this->morphMany(DailyPrice::class, 'affordable');
    }

}
