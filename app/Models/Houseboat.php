<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\IsPriceable;
use App\Traits\Models\IsRentable;
use Database\Factories\HouseboatFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rentals
 *
 * @property int $id
 * @property int $houseboat_model_id
 * @property string $name
 * @property-read Collection|HouseboatRentals[] $dates
 * @property-read int|null $dates_count
 * @property-read HouseboatModel|null $model
 * @method static HouseboatFactory factory(...$parameters)
 * @method static Builder|Houseboat newModelQuery()
 * @method static Builder|Houseboat newQuery()
 * @method static Builder|Houseboat query()
 * @method static Builder|Houseboat whereHouseboatModelId($value)
 * @method static Builder|Houseboat whereId($value)
 * @method static Builder|Houseboat whereName($value)
 * @mixin Eloquent
 * @property int|null $houseboat_owner_id
 * @property string|null $calendar_color
 * @property-read HouseboatOwner|null $owner
 * @method static Builder|Houseboat whereCalendarColor($value)
 * @method static Builder|Houseboat whereHouseboatOwnerId($value)
 * @property-read Collection|\App\Models\Rentable[] $rentables
 * @property-read int|null $rentables_count
 * @property-read Collection|\App\Models\Rentable[] $rentals
 * @property-read int|null $rentals_count
 */
class Houseboat extends Model
{
    use HasFactory, IsRentable, IsPriceable;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['model'];

    public function model()
    {
        return $this->belongsTo(HouseboatModel::class, 'houseboat_model_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(HouseboatOwner::class, 'houseboat_owner_id', 'id');
    }

    public function rentals()
    {
        return $this->morphMany(Rentable::class, 'rentable');
    }
}
