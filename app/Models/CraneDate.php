<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CraneDate
 *
 * @property int $id
 * @property string $cranable_type
 * @property int $cranable_id
 * @property \Illuminate\Support\Carbon|null $date
 * @property \Illuminate\Support\Carbon $crane_date
 * @property string|null $crane_time
 * @property-read Model|\Eloquent $cranable
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate query()
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate whereCranableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate whereCranableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate whereCraneDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate whereCraneTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CraneDate whereId($value)
 * @mixin \Eloquent
 */
class CraneDate extends Model
{
    use HasFactory;

    protected $table = 'crane_dates';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = [
		'date' => 'datetime:Y-m-d H.i',
        'crane_date' => 'date:d.m.Y',
    ];

    public function cranable()
    {
        return $this->morphTo();
    }
}
