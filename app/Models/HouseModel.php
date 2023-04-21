<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HouseModel
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $space
 * @property int $floors
 * @property int $sleeping_places
 * @property int|null $peak_season_price
 * @property int|null $mid_season_price
 * @property int|null $low_season_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\House[] $houses
 * @property-read int|null $houses_count
 * @method static \Database\Factories\HouseModelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereLowSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereMidSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel wherePeakSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereSleepingPlaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereSpace($value)
 * @mixin \Eloquent
 */
class HouseModel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function houses()
    {
        return $this->hasMany(House::class, 'house_model_id', 'id');
    }
}
