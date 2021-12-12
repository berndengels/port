<?php

namespace App\Traits\Models;

trait HasFromUntilDates
{
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
