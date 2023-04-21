<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BerthMap
 *
 * @property int $id
 * @property int $berth_id
 * @property int $w
 * @property int $h
 * @property int $x
 * @property int $y
 * @property-read \App\Models\Berth|null $berth
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap query()
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap whereBerthId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap whereH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap whereW($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap whereX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap whereY($value)
 * @mixin \Eloquent
 * @property int|null $angle
 * @method static \Illuminate\Database\Eloquent\Builder|BerthMap whereAngle($value)
 */
class BerthMap extends Model
{
    use HasFactory;

    protected $table = 'berth_maps';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function berth()
    {
        return $this->belongsTo(Berth::class);
    }
}
