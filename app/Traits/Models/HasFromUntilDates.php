<?php

namespace App\Traits\Models;

use App\Models\Rentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Period\Period;

trait HasFromUntilDates
{
    public function scopeDatesBetween(Builder $query, Carbon $from = null, Carbon $until = null)
    {
        if($from && $until) {
            return $query
                ->whereBetween('from', [$from, $until])
                ->orWhereBetween('until', [$from, $until]);
        } elseif ($from) {
            return $query->whereDate('from', '>=', $from );
        } elseif ($until) {
            return $query->whereDate('until', '<=', $until );
        } else {
            return $query;
        }
    }

    public function getValidFromAttribute()
    {
        if($this->from) {
            return $this->from->format('Y-m-d');
        }
        return null;
    }

    public function getValidUntilAttribute()
    {
        if($this->until) {
            return $this->until->format('Y-m-d');
        }
        return null;
    }

    public function getDaysAttribute()
    {
        if($this->from && $this->until) {
            return $this->from->diffInDays($this->until);
        }
        return null;
    }
}
