<?php

namespace App\Models;

use Database\Factories\BothDockFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\BothDock
 *
 * @property-read Collection|GuestBoatBerth[] $berths
 * @property-read int|null $berths_count
 * @method static BothDockFactory factory(...$parameters)
 * @method static Builder|BoatDock newModelQuery()
 * @method static Builder|BoatDock newQuery()
 * @method static Builder|BoatDock query()
 * @mixin Eloquent
 */
class BoatDock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function berths() {
        return $this->hasMany(GuestBoatBerth::class, 'boat_dock_id', 'id');
    }
}
