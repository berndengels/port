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
 * @property string $number
 * @property string|null $width
 * @property string|null $length
 * @property string|null $daily_price
 * @property float|null $lat
 * @property float|null $lng
 * @property int $enabled
 * @property-read Collection|GuestBoatDates[] $guestBoatDates
 * @property-read int|null $guest_boat_dates_count
 * @method static BerthFactory factory(...$parameters)
 * @method static Builder|Berth newModelQuery()
 * @method static Builder|Berth newQuery()
 * @method static Builder|Berth query()
 * @method static Builder|Berth whereDailyPrice($value)
 * @method static Builder|Berth whereEnabled($value)
 * @method static Builder|Berth whereId($value)
 * @method static Builder|Berth whereLat($value)
 * @method static Builder|Berth whereLength($value)
 * @method static Builder|Berth whereLng($value)
 * @method static Builder|Berth whereNumber($value)
 * @method static Builder|Berth whereWidth($value)
 * @mixin Eloquent
 * @property int|null $boat_dock_id
 * @property-read Dock|null $dock
 * @method static Builder|Berth whereBoatDockId($value)
 * @property int|null $berth_category_id
 * @property-read BerthCategory|null $category
 * @method static Builder|Berth whereBerthCategoryId($value)
 * @property-read \App\Models\BerthMap|null $map
 * @property int|null $dock_id
 * @property-read Collection|\App\Models\Boat[] $boats
 * @property-read int|null $boats_count
 * @method static Builder|Berth whereDockId($value)
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
