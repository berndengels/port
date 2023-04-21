<?php

namespace App\Models;

use App\Traits\Models\IsPriceable;
use App\Traits\Models\IsRentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Apartment
 *
 * @property int $id
 * @property int $apartment_model_id
 * @property string $name
 * @property string|null $calendar_color
 * @property-read \App\Models\ApartmentModel|null $model
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rentable[] $rentables
 * @property-read int|null $rentables_count
 * @method static \Database\Factories\ApartmentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Apartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Apartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Apartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Apartment whereApartmentModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Apartment whereCalendarColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Apartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Apartment whereName($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Rentable[] $rentals
 * @property-read int|null $rentals_count
 */
class Apartment extends Model
{
    use HasFactory, IsRentable, IsPriceable;
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['model'];

    public function model()
    {
        return $this->belongsTo(ApartmentModel::class,'apartment_model_id', 'id');
    }

    public function rentals()
    {
        return $this->morphMany(Rentable::class, 'rentable');
    }
}
