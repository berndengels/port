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
    public $timestamps = false;

    public function boat() {
        return $this->belongsTo(Boat::class);
    }
}
