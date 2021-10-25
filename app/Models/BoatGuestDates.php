<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\boatGuestDates
 *
 * @method static Builder|boatGuestDates newModelQuery()
 * @method static Builder|boatGuestDates newQuery()
 * @method static Builder|boatGuestDates query()
 * @mixin Eloquent
 */
class BoatGuestDates extends Model
{
    use HasFactory, ClearCache, Filter;

    protected $table = 'boat_guest_dates';
    protected $guarded = ['id'];
    protected $dates = ['from', 'until'];
    protected $dateFormat = 'Y-m-d';
    protected $appends = [
        'validFrom',
        'validUntil',
    ];
    public $timestamps = false;

    public function boat() {
        return $this->belongsTo(BoatGuest::class, 'boat_guest_id', 'id');
    }

    public function getValidFromAttribute() {
        return $this->from->format('Y-m-d');
    }

    public function getValidUntilAttribute() {
        return $this->until->format('Y-m-d');
    }
}
