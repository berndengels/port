<?php

namespace App\Models;

use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $subject
 * @property string $message
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Database\Factories\ContactFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filter(?string $name = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filterDateFrom(?string $name = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filterDateUntil(?string $name = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filterMonth(?string $name = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact filterYear(?string $name = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact likeFilter(?string $name = null, $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSubject($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use HasFactory,Filter;

    protected $guarded = ['id'];
    const UPDATED_AT = null;
    public $timestamps = ['created_at'];
    protected $casts = [
        'created_at'    => 'datetime:d.m.Y H.i',
    ];
}
