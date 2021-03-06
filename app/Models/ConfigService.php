<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigService
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @method static \Database\Factories\ConfigServiceFactory factory(...$parameters)
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
}
