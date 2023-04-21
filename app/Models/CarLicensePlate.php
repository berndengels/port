<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\CarLicensePlate
 *
 * @property int $id
 * @property int $country_id
 * @property string $code
 * @property string $location
 * @property string $district
 * @property string $state
 * @method static Builder|CarLicensePlate newModelQuery()
 * @method static Builder|CarLicensePlate newQuery()
 * @method static Builder|CarLicensePlate query()
 * @method static Builder|CarLicensePlate whereCode($value)
 * @method static Builder|CarLicensePlate whereCountryId($value)
 * @method static Builder|CarLicensePlate whereDistrict($value)
 * @method static Builder|CarLicensePlate whereId($value)
 * @method static Builder|CarLicensePlate whereLocation($value)
 * @method static Builder|CarLicensePlate whereState($value)
 * @mixin Eloquent
 */
class CarLicensePlate extends BaseModel
{
    use HasFactory, ClearCache;

    protected $table = 'car_license_plates';
    protected $guarded = ['id'];
    public $timestamps = false;

    /*
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    */
}
