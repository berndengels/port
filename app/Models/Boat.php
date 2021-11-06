<?php
namespace App\Models;

use Eloquent;
use Database\Factories\BoatFactory;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Boat
 *
 * @property      int $id
 * @property      int $customer_id
 * @property      string $boat_type
 * @property      string $boat_name
 * @property      string|null $length
 * @property      string|null $width
 * @property      string|null $draft
 * @property      string|null $length_waterline
 * @property      string|null $length_keel
 * @property      string|null $home_port
 * @property-read Customer $customer
 * @method        static Builder|Boat newModelQuery()
 * @method        static Builder|Boat newQuery()
 * @method        static Builder|Boat query()
 * @method        static Builder|Boat whereBoatName($value)
 * @method        static Builder|Boat whereBoatType($value)
 * @method        static Builder|Boat whereCustomerId($value)
 * @method        static Builder|Boat whereDraft($value)
 * @method        static Builder|Boat whereHomePort($value)
 * @method        static Builder|Boat whereId($value)
 * @method        static Builder|Boat whereLength($value)
 * @method        static Builder|Boat whereLengthKeel($value)
 * @method        static Builder|Boat whereLengthWaterline($value)
 * @method        static Builder|Boat whereWidth($value)
 * @mixin         Eloquent
 * @property      int|null $weight
 * @property      int|null $mast_length
 * @property      int|null $mast_weight
 * @property-read Collection|BoatDates[] $dates
 * @property-read int|null $dates_count
 * @method        static Builder|Boat whereMastLength($value)
 * @method        static Builder|Boat whereMastWeight($value)
 * @method        static Builder|Boat whereWeight($value)
 * @method        static BoatFactory factory(...$parameters)
 */
class Boat extends BaseModel
{
    use HasFactory, ClearCache;

    protected $table = 'boats';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function dates()
    {
        return $this->hasMany(BoatDates::class);
    }
}
