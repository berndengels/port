<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RentableModel
 *
 * @property int $id
 * @property int|null $rentable_id
 * @property string|null $rentable_type
 * @property string $name
 * @property string $description
 * @property int $space
 * @property int $floors
 * @property int $sleeping_places
 * @property int|null $peak_season_price
 * @property int|null $mid_season_price
 * @property int|null $low_season_price
 * @method static \Database\Factories\RentableModelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereLowSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereMidSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel wherePeakSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereRentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereRentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereSleepingPlaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RentableModel whereSpace($value)
 * @mixin \Eloquent
 */
class RentableModel extends Model
{
    use HasFactory;

    protected $table = 'rentable_models';
    protected $guarded = ['id'];
    public $timestamps = false;

}
