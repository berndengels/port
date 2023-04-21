<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UseBooleanIcon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigHoliday
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property bool $enabled
 * @method static Builder|ConfigHoliday newModelQuery()
 * @method static Builder|ConfigHoliday newQuery()
 * @method static Builder|ConfigHoliday query()
 * @method static Builder|ConfigHoliday whereEnabled($value)
 * @method static Builder|ConfigHoliday whereId($value)
 * @method static Builder|ConfigHoliday whereKey($value)
 * @method static Builder|ConfigHoliday whereName($value)
 * @mixin Eloquent
 */
class ConfigHoliday extends Model
{
    use HasFactory;
    use UseBooleanIcon;

    protected $table = 'config_holidays';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
