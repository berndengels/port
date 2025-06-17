<?php

namespace App\Libs\Prices;

use Exception;
use Illuminate\Support\Str;
use App\Models\ConfigEntity;
use Illuminate\Support\Facades\Log;
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
    protected $unitInclusive;
	protected $unitPrice;
    protected $priceType;
	protected $priceUnitRangeType;
	protected $unitFromPrice;
	protected $unitUntilPrice;
	protected $priceUnitRange;
    /**
     * @param ConfigPriceComponent $priceComponents
     */
    public function __construct()
    {
        $this->priceComponents = ConfigEntity::with('priceComponents')
            ->whereModel($this->model)
            ->first()
            ->priceComponents
            ->keyBy(fn(ConfigPriceComponent $c) => 'price' . ucfirst(Str::camel($c->key)));

        $this->priceComponentKey = (string) Str::of(class_basename(static::class))->snake();

        if('base' !== $this->priceComponentKey) {
			try {
				$this->priceComponent = $this->priceComponents
					->where('key','=', $this->priceComponentKey)
					->first();

				if($this->priceComponent) {
					$this->unitPrice = $this->priceComponent->unit_price ?? null;
					$this->priceType = $this->priceComponent->priceType?->type ?? null;
					$this->unitInclusive = $this->priceComponent->unit_inclusive ?? null;
					$this->priceUnitRange = $this->priceComponent->unitRangeType ?? null;
					$this->priceUnitRangeType = $this->priceComponent->unitRangeType?->type ?? null;

					if($this->priceUnitRange) {
						$this->unitFromPrice = $this->priceComponent->unit_from ?? null;
						$this->unitUntilPrice = $this->priceComponent->unit_until ?? null;
					}
				}
			} catch(Exception $e) {
//				Log::channel('my')->error($e->getMessage());
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
