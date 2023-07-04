<?php

namespace App\Models;

use Eloquent;
use Database\Factories\DockFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Dock
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $length
 * @property int|null $min_box_length
 * @property int|null $max_box_length
 * @property-read Collection<int, \App\Models\Berth> $berths
 * @property-read int|null $berths_count
 * @method static Builder|Dock newModelQuery()
 * @method static Builder|Dock newQuery()
 * @method static Builder|Dock query()
 * @method static Builder|Dock whereId($value)
 * @method static Builder|Dock whereLength($value)
 * @method static Builder|Dock whereMaxBoxLength($value)
 * @method static Builder|Dock whereMinBoxLength($value)
 * @method static Builder|Dock whereName($value)
 * @mixin Eloquent
 */
class Dock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function berths() {
        return $this->hasMany(Berth::class);
    }
}
