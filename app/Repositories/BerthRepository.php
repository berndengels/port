<?php
namespace App\Repositories;

use App\Models\Berth;
use App\Libs\AppCache;
use App\Repositories\Ext\SelectOptions;

class BerthRepository extends Repository
{
    use SelectOptions;

    protected static $model = Berth::class;
    protected static $cacheKeyOptions = AppCache::KEY_OPTIONS_BERTH;
    protected static $cacheKeyOptionsData = AppCache::KEY_OPTIONS_DATA_BERTH;

    public function getOptionsData($orderBy = 'number', $relations = null)
    {
        $modifiedRelations = [];
        if($relations) {
            if(is_string($relations)) {
                $modifiedRelations = ['dock', $relations];
            } elseif(is_array($relations)) {
                array_push($modifiedRelations, 'dock');
            }
            $modifiedRelations = array_unique($modifiedRelations);
        }
        $query = Berth::with($modifiedRelations)
            ->whereBerthCategoryId(1)
            ->orderBy('number')
        ;

        $this->selectOptionsData = $query->get()->keyBy('id')
            ->map(fn(Berth $item) => ($item->dock->name ?? '') . $item->number)
        ;

        return $this->selectOptionsData;
    }
}
