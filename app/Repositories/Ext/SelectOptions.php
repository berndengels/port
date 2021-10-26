<?php
namespace App\Repositories\Ext;

use App\Libs\AppCache;
use Illuminate\Support\Facades\Cache;

trait SelectOptions
{
    protected $selectOptions;
    protected $selectOptionsData;

    public function getOptionsData($orderBy = 'name', $relations = [])
    {
        $query = (static::$model)::with($relations)
            ->select()
            ->orderBy($orderBy)
        ;
        $this->selectOptionsData = $query->get();
        return $this->selectOptionsData;
    }

    public function optionsData($orderBy = 'name', $relations = [])
    {
        return Cache::remember(static::$cacheKeyOptionsData, AppCache::TTL, fn() => $this->getOptionsData(
            orderBy: $orderBy,
            relations: $relations
        ));
    }

    public function options($textFieldName = 'name', $keyFieldName = 'id', $relations = [])
    {
        $this->selectOptionsData = $this->optionsData(
            orderBy: $textFieldName,
            relations: $relations
        );
        $this->selectOptions = Cache::remember(static::$cacheKeyOptions, AppCache::TTL, function() use ($keyFieldName, $textFieldName) {
            return $this->selectOptionsData
                ->keyBy($keyFieldName)
                ->map->{$textFieldName}
            ;
        });
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSelectOptions()
    {
        return $this->selectOptions;
    }

    /**
     * @return mixed
     */
    public function getSelectOptionsData()
    {
        return $this->selectOptionsData;
    }
}
