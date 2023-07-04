<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\UseBooleanIcon;
use Database\Factories\BerthFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GuestBoatBerth
 *
 * @property int $id
 * @property int|null $dock_id
 * @property int|null $berth_category_id
 * @property string $number
 * @property float|null $width
 * @property float|null $length
 * @property float|null $daily_price
 * @property float|null $lat
 * @property float|null $lng
 * @property bool $enabled
 * @property-read Collection<int, \App\Models\Boat> $boats
 * @property-read int|null $boats_count
 * @property-read \App\Models\BerthCategory|null $category
 * @property-read \App\Models\Dock|null $dock
 * @property-read Collection<int, \App\Models\GuestBoatDates> $guestBoatDates
 * @property-read int|null $guest_boat_dates_count
 * @property-read \App\Models\BerthMap|null $map
 * @method static \Database\Factories\BerthFactory factory($count = null, $state = [])
 * @method static Builder|Berth newModelQuery()
 * @method static Builder|Berth newQuery()
 * @method static Builder|Berth query()
 * @method static Builder|Berth whereBerthCategoryId($value)
 * @method static Builder|Berth whereDailyPrice($value)
 * @method static Builder|Berth whereDockId($value)
 * @method static Builder|Berth whereEnabled($value)
 * @method static Builder|Berth whereId($value)
 * @method static Builder|Berth whereLat($value)
 * @method static Builder|Berth whereLength($value)
 * @method static Builder|Berth whereLng($value)
 * @method static Builder|Berth whereNumber($value)
 * @method static Builder|Berth whereWidth($value)
 * @mixin Eloquent
 */
class Berth extends Model
{
    use HasFactory;
    use UseBooleanIcon;

    protected $guarded = ['id'];
    protected $with = ['dock'];
    public $timestamps = false;
//    protected $appends = ['name'];
    protected $casts = [
        'enabled'       => 'boolean',
        'width'         => 'float',
        'length'        => 'float',
        'daily_price'   => 'float',
    ];

    public function guestBoatDates()
    {
        return $this->hasMany(GuestBoatDates::class);
    }

    public function boats()
    {
        return $this->hasMany(Boat::class);
    }

    public function dock()
    {
        return $this->belongsTo(Dock::class, 'dock_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(BerthCategory::class, 'berth_category_id', 'id');
    }
    public function map()
    {
        return $this->hasOne(BerthMap::class);
    }
}
