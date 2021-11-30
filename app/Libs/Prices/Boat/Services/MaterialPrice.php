<?php

namespace App\Libs\Prices\Boat\Services;

use App\Models\Boat;
use App\Models\ConfigPriceType;
use App\Libs\Prices\Price;

class MaterialPrice
{
    protected $price;
    protected $targetValue;

    public function __construct(
        protected Boat $boat,
        protected string $modus,
        protected float $fertility,
        protected float $pricePerUnit,
        protected string $fertilityUnit
    )
    {
        switch ($this->fertilityUnit) {
            case 'Quadratmeter':
                switch ($modus) {
                    case 'underwater':
                        $this->targetValue = $this->boat->underwaterArea;
                        break;
                    case 'board';
                    default:
                        $this->targetValue = $this->boat->boardArea;
                        break;
                }
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
