<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApartmentModel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Apartment[] $apartments
 * @property-read int|null $apartments_count
 * @method static \Database\Factories\ApartmentModelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $space
 * @property int $floors
 * @property int $sleeping_places
 * @property int|null $peak_season_price
 * @property int|null $mid_season_price
 * @property int|null $low_season_price
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereLowSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereMidSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel wherePeakSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereSleepingPlaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereSpace($value)
 */
class ApartmentModel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'apartment_model_id', 'id');
    }

}
