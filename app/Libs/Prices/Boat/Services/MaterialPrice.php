<?php

namespace App\Libs\Prices\Boat\Services;

use App\Models\Boat;
use App\Models\PriceType;
use App\Libs\Prices\Price;

class MaterialPrice
{
    protected $price;
    protected $targetValue;

    public function __construct(
        protected Boat $boat,
        protected float $fertility,
        protected float $pricePerUnit,
        protected string $fertilityUnit
    )
    {
        switch ($this->fertilityUnit) {
            case 'Quadratmeter':
                $this->targetValue = $this->boat->getUnderwaterShipArea();
                break;
            case 'Meter':
                $this->targetValue = $this->boat->length;
                break;
            default:
                break;
        }

        if($this->targetValue) {
            $this->price = new Price($this->targetValue * $this->pricePerUnit / $this->fertility);
        }
    }

    /**
     * @return float|int
     */
    public function getPrice(): float|int
    {
        if($this->price && $this->price instanceof Price) {
            return $this->price->getValue();
        }
        return 0;
    }
}
