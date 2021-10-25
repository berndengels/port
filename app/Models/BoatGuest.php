<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\boatGuest
 *
 * @method static Builder|boatGuest newModelQuery()
 * @method static Builder|boatGuest newQuery()
 * @method static Builder|boatGuest query()
 * @mixin Eloquent
 */
class BoatGuest extends Model
{
    use HasFactory, ClearCache, Filter;

    protected $table = 'boat_guests';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function dates() {
        return $this->hasMany(BoatGuestDates::class);
    }
}
