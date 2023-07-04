<?php
namespace App\Models;

use Database\Factories\WidgetFactory;
use Eloquent;
use Illuminate\Support\Str;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Widget
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string $content
 * @property int $position
 * @property string|null $class
 * @property string|null $bgColor
 * @property string|null $color
 * @method static \Database\Factories\WidgetFactory factory($count = null, $state = [])
 * @method static Builder|Widget newModelQuery()
 * @method static Builder|Widget newQuery()
 * @method static Builder|Widget query()
 * @method static Builder|Widget whereBgColor($value)
 * @method static Builder|Widget whereClass($value)
 * @method static Builder|Widget whereColor($value)
 * @method static Builder|Widget whereContent($value)
 * @method static Builder|Widget whereId($value)
 * @method static Builder|Widget wherePosition($value)
 * @method static Builder|Widget whereSlug($value)
 * @method static Builder|Widget whereTitle($value)
 * @mixin Eloquent
 */
class Widget extends BaseModel
{
    use HasFactory, HasSlug, ClearCache;

    protected $table = 'widgets';
    protected $guarded = ['id'];
    public $timestamps = false;

}
