<?php
namespace App\Repositories;

use App\Models\Boat;
use App\Libs\AppCache;
use App\Repositories\Ext\SelectOptions;
use Illuminate\Database\Eloquent\Builder;

class BoatRepository extends Repository
{
    use SelectOptions;

    protected static $model = Boat::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_BOAT;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_BOAT;

    public function getOptionsData($orderBy = 'name', $relations = [])
    {
        $this->selectOptionsData = Boat::on(app('db.connection')->getName())
            ->with('customer')
            ->whereHas(
                'customer', function (Builder $query) {
                    $query->where('customer_type', '=', 'permanent');
                }
            )
            ->orderBy('boat_name')
            ->get();

        return $this->selectOptionsData;
    }
}
