<?php

namespace App\Models;

use Database\Factories\BerthCategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BerthCategory
 *
 * @property int $id
 * @property string $name
 * @property-read Collection|Berth[] $berths
 * @property-read int|null $berths_count
 * @method static BerthCategoryFactory factory(...$parameters)
 * @method static Builder|BerthCategory newModelQuery()
 * @method static Builder|BerthCategory newQuery()
 * @method static Builder|BerthCategory query()
 * @method static Builder|BerthCategory whereId($value)
 * @method static Builder|BerthCategory whereName($value)
 * @mixin Eloquent
 */
class BerthCategory extends Model
{
    use HasFactory;

    protected $table = 'berth_categories';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function berths()
    {
        return $this->hasMany(Berth::class);
    }
}
