<?php
namespace App\Repositories\Ext;

use App\Libs\AppCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait SelectOptions
{
    /**
     * @var Collection
     */
    protected $selectOptions;
    /**
     * @var Collection
     */
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

    public function optionsData($orderBy = 'name', $relations = []): Collection
    {
        return Cache::remember(static::$cacheKeyOptionsData, AppCache::TTL, fn() => $this->getOptionsData(
            orderBy: $orderBy,
            relations: $relations
        ));
    }

    public function options($textFieldName = 'name', $keyFieldName = 'id', $relations = []): self
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
     * @return Collection
     */
    public function getSelectOptions(): Collection
    {
        return $this->selectOptions;
    }

    /**
     * @return Collection
     */
    public function getSelectOptionsData(): Collection
    {
        return $this->selectOptionsData;
    }
}
