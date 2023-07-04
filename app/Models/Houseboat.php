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
 * @property int|null $houseboat_owner_id
 * @property string $name
 * @property string|null $calendar_color
 * @property-read \App\Models\HouseboatModel $model
 * @property-read \App\Models\HouseboatOwner|null $owner
 * @property-read Collection<int, \App\Models\Rentable> $rentals
 * @property-read int|null $rentals_count
 * @method static \Database\Factories\HouseboatFactory factory($count = null, $state = [])
 * @method static Builder|Houseboat newModelQuery()
 * @method static Builder|Houseboat newQuery()
 * @method static Builder|Houseboat query()
 * @method static Builder|Houseboat whereCalendarColor($value)
 * @method static Builder|Houseboat whereHouseboatModelId($value)
 * @method static Builder|Houseboat whereHouseboatOwnerId($value)
 * @method static Builder|Houseboat whereId($value)
 * @method static Builder|Houseboat whereName($value)
 * @mixin Eloquent
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
