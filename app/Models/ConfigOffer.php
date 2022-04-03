<?php

namespace App\Models;

use App\Traits\Models\UseBooleanIcon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigOffer
 *
 * @property int $id
 * @property string $name
 * @property bool $enabled
 * @method static Builder|ConfigOffer newModelQuery()
 * @method static Builder|ConfigOffer newQuery()
 * @method static Builder|ConfigOffer query()
 * @method static Builder|ConfigOffer whereEnabled($value)
 * @method static Builder|ConfigOffer whereId($value)
 * @method static Builder|ConfigOffer whereName($value)
 * @mixin Eloquent
 */
class ConfigOffer extends Model
{
    use HasFactory, UseBooleanIcon;

    protected $table = 'config_offers';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = [
        'enabled' => 'boolean',
    ];
}
