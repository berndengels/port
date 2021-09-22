<?php

namespace App\Models;

use Database\Factories\CaravanFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Caravan
 *
 * @property int $id
 * @property string $carnumber
 * @property int $carlength
 * @property-read Collection|CaravanDates[] $dates
 * @property-read int|null $dates_count
 * @method static Builder|Caravan newModelQuery()
 * @method static Builder|Caravan newQuery()
 * @method static Builder|Caravan query()
 * @method static Builder|Caravan whereCarlength($value)
 * @method static Builder|Caravan whereCarnumber($value)
 * @method static Builder|Caravan whereId($value)
 * @mixin Eloquent
 * @property string|null $email
 * @method static CaravanFactory factory(...$parameters)
 * @method static Builder|Caravan whereEmail($value)
 * @property int $country_id
 * @property-read Country $country
 * @method static Builder|Caravan whereCountryId($value)
 */
class Caravan extends Model
{
    use HasFactory;

    protected $table = 'caravans';
    protected $guarded = ['id'];
    protected $appends = ['text'];
    public $timestamps = false;

    protected $casts = [
        'carlength' => 'integer',
    ];

    public function getTextAttribute()
    {
        return $this->carnumber;
    }

    public function dates() {
        return $this->hasMany(CaravanDates::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
