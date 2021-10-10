<?php

namespace App\Models;

use App\Models\Filter\HasSlug;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string $content
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereContent($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereTitle($value)
 * @mixin Eloquent
 */
class Page extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'pages';
    protected $guarded = ['id'];
    public $timestamps = false;
}
