<?php

namespace App\Models;

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
 */
class Caravan extends Model
{
    use HasFactory;

    protected $table = 'caravans';
    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'carlength' => 'integer',
    ];
    public function dates() {
        return $this->hasMany(CaravanDates::class);
    }
}
