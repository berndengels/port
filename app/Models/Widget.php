<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\Filter\HasSlug;
use App\Traits\Models\ClearsResponseCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\Widget
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property string $content
 * @property int $position
 * @method static Builder|Widget newModelQuery()
 * @method static Builder|Widget newQuery()
 * @method static Builder|Widget query()
 * @method static Builder|Widget whereContent($value)
 * @method static Builder|Widget whereId($value)
 * @method static Builder|Widget wherePosition($value)
 * @method static Builder|Widget whereSlug($value)
 * @method static Builder|Widget whereTitle($value)
 * @mixin Eloquent
 */
class Widget extends Model
{
    use HasFactory, HasSlug, ClearsResponseCache;

    protected $table = 'widgets';
    protected $guarded = ['id'];
    public $timestamps = false;

}
