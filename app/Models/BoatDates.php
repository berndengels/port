<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BoatDates
 *
 * @method static Builder|BoatDates newModelQuery()
 * @method static Builder|BoatDates newQuery()
 * @method static Builder|BoatDates query()
 * @mixin Eloquent
 */
class BoatDates extends Model
{
    use HasFactory;

    protected $table = 'boat_dates';
    protected $guarded = ['id'];
    protected $dates = ['from', 'until'];
    protected $dateFormat = 'Y-m-d';
    protected $appends = ['validFrom','validUntil'];
    public $timestamps = false;

    public function boat() {
        return $this->belongsTo(Boat::class);
    }

    public function getValidFromAttribute() {
        return $this->from->format('Y-m-d');
    }

    public function getValidUntilAttribute() {
        return $this->until->format('Y-m-d');
    }
}
