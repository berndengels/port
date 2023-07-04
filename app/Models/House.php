<?php

namespace App\Models;

use App\Traits\Models\IsPriceable;
use App\Traits\Models\IsRentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\House
 *
 * @property int $id
 * @property int $house_model_id
 * @property string $name
 * @property string|null $calendar_color
 * @property-read \App\Models\HouseModel $model
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rentable> $rentals
 * @property-read int|null $rentals_count
 * @method static \Database\Factories\HouseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|House newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|House newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|House query()
 * @method static \Illuminate\Database\Eloquent\Builder|House whereCalendarColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereHouseModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|House whereName($value)
 * @mixin \Eloquent
 */
class House extends Model
{
    use HasFactory, IsRentable, IsPriceable;

    protected $guarded = ['id'];
//    protected $with = ['model'];
    public $timestamps = false;
    protected $with = ['model'];

    public function model()
    {
        return $this->belongsTo(HouseModel::class, 'house_model_id', 'id');
    }

    public function rentals()
    {
        return $this->morphMany(Rentable::class, 'rentable');
    }
}
