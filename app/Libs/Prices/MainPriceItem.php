<?php

namespace App\Libs\Prices;

use Illuminate\Support\Str;
use App\Models\ConfigEntity;
use App\Models\ConfigPriceComponent;

class MainPriceItem
{
    protected $model;
    protected $daysCount = 0;
    /**
     * @var ConfigPriceComponent
     */
    protected $priceComponents;
    protected $priceComponentKey;
    /**
     * @var ConfigPriceComponent
     */
    protected $priceComponent;
    protected $unitPrice;
    protected $unitInclusive;
    protected $priceType;
    /**
     * @param ConfigPriceComponent $priceComponents
     */
    public function __construct()
    {
        $this->priceComponents = ConfigEntity::with('priceComponents')
            ->whereModel($this->model)
            ->first()
            ->priceComponents
            ->keyBy(fn(ConfigPriceComponent $c) => 'price' . ucfirst(Str::camel($c->key)))
        ;

        $this->priceComponentKey = (string) Str::of(class_basename(static::class))->snake();

        if('base' !== $this->priceComponentKey) {
            $this->priceComponent = $this->priceComponents
                ->where('key','=', $this->priceComponentKey)
                ->first();

            if($this->priceComponent) {
                $this->unitPrice = $this->priceComponent->unit_price ?? null;
                $this->priceType = $this->priceComponent->priceType?->type ?? null;
                $this->unitInclusive = $this->priceComponent->unit_inclusive ?? null;
            }
        }
    }


    /**
     * @return int
     */
    public function getDaysCount(): int
    {
        return $this->daysCount;
    }

    /**
     * @param  int $daysCount
     * @return MainPriceItem
     */
    public function setDaysCount(int $daysCount): MainPriceItem
    {
        $this->daysCount = $daysCount;
        return $this;
    }
}
