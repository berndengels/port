<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string $content
 * @property int|null $is_public
 * @method static \Database\Factories\PageFactory factory($count = null, $state = [])
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereContent($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereIsPublic($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereTitle($value)
 * @mixin Eloquent
 */
class Page extends BaseModel
{
    use HasFactory, HasSlug, ClearCache;

    protected $table = 'pages';
    protected $guarded = ['id'];
    public $timestamps = false;
}
