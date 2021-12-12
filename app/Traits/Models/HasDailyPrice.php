<?php

namespace App\Traits\Models;

use App\Models\ConfigDailyPrice;
use Illuminate\Database\Eloquent\Builder;

trait HasDailyPrice
{
    public function scopeDailyPrices()
    {
        $fromDay = $this->from->format('d');
        $fromMonth = $this->from->format('m');
        $untilDay = $this->until->format('d');
        $untilMonth = $this->until->format('m');

        return ConfigDailyPrice::whereModel(static::class)
            ->whereHas('saison', fn(Builder $q) =>
                $q->where('from_month','<=', $fromMonth)
                && $q->where('until_month','>=', $untilMonth)
                && $q->where('from_day','<=', $fromDay)
                && $q->where('until_day','>=', $untilDay)
            );
    }

}
