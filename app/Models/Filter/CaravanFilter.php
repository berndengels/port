<?php
namespace App\Models\Filter;

use Illuminate\Database\Eloquent\Builder;

trait CaravanFilter
{
    public function scopeCaravan(Builder $builder, int $caravanId = null) : Builder
    {
        if($caravanId) {
            $builder->whereId($caravanId);
        }
        return $builder;
    }

    public function scopeCaravanByDates(Builder $builder, int $caravanId = null) : Builder
    {
        if($caravanId) {
            $builder->whereCaravanId($caravanId);
        }
        return $builder;
    }
}
