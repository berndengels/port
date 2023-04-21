<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AccessLog
 *
 * @property int $id
 * @property string $ip
 * @property string $city
 * @property string $country
 * @property string $state
 * @property string $postal_code
 * @property string $user_agent
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessLog whereUserAgent($value)
 * @mixin \Eloquent
 */
class AccessLog extends Model
{
    const UPDATED_AT = null;
    protected $table = 'access_logs';
    protected $guarded = ['id'];
    public $timestamps = ['created_at'];
}
