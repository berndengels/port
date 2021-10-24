<?php

namespace App\Models;

use App\Traits\Models\ClearsResponseCache;
use App\Traits\Models\Filter\Filter;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    use HasFactory, ClearsResponseCache, Filter;

    protected $table = 'boat_guests';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function dates() {
        return $this->hasMany(BoatGuestDates::class);
    }
}
