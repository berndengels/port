<?php
namespace App\Repositories\Ext;

use App\Libs\AppCache;
use Illuminate\Database\Query\Builder;
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

    public function getOptionsData($orderBy = 'name', $relations = [], ?array $where = []): Collection|null
    {
        /**
         * @var $query Builder
         */
        $query = (static::$model)::on(app('db.connection')->getName())
            ->with($relations)
            ->select()
            ->orderBy($orderBy);

        if($where) {
            foreach ($where as $c => $v) {
                $query->where($c,'=', $v);
            }
        }
        /*
        * only for tests
        $this->selectOptionsData = $query->get()->map(function ($item) use ($orderBy) {
            $item->{$orderBy} = _config('app.env').' '.$item->{$orderBy};
            return $item;
        });
        */
        $this->selectOptionsData = $query->get();
        return $this->selectOptionsData;
    }

    public function optionsData(
        $orderBy = 'name',
        $relations = [],
        ?array $where = []
    ): Collection|null
    {
        return Cache::remember(
            static::$cacheKeyOptionsData, AppCache::TTL, fn() => $this->getOptionsData(
                $orderBy,
                $relations,
                $where
            )
        );
    }

    public function options(
        $textFieldName = 'name',
        $keyFieldName = 'id',
        $relations = [],
        ?array $where = [],
        ?\Closure $callback = null
    ): self
    {
        if(is_callable($callback)) {
            return $callback($this);
        }

        $this->selectOptionsData = $this->optionsData(
            $textFieldName,
            $relations,
            $where
        );
        $this->selectOptions = Cache::remember(
            static::$cacheKeyOptions, AppCache::TTL, fn () =>
                $this->selectOptionsData
                    ->keyBy($keyFieldName)
                    ->map->{$textFieldName}
        );
        return $this;
    }

    public function translate()
    {
        $this->selectOptions = $this->selectOptions->map(fn ($el) => __($el));
        return $this;
    }

    /**
     * @return Collection
     */
    public function getSelectOptions(): Collection|null
    {
        return $this->selectOptions;
    }

    /**
     * @return Collection
     */
    public function getSelectOptionsData(): Collection|null
    {
        return $this->selectOptionsData;
    }
}
