<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigService
 *
 * @property int $id
 * @property string $name
 * @property string|null $key
 * @method static \Database\Factories\ConfigServiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigService query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigService whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigService whereName($value)
 * @mixin \Eloquent
 */
class ConfigService extends BaseModel
{
    use HasFactory;

    protected $table = 'config_services';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = Str::of($value)->snake();
    }
}
