<?php

namespace App\Models;

use App\Traits\Models\ClearsResponseCache;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\boatGuestDates
 *
 * @method static Builder|boatGuestDates newModelQuery()
 * @method static Builder|boatGuestDates newQuery()
 * @method static Builder|boatGuestDates query()
 * @mixin Eloquent
 */
class boatGuestDates extends Model
{
    use HasFactory, ClearsResponseCache;

    protected $table = '';
    protected $guarded = ['id'];
    public $timestamps = false;
}
