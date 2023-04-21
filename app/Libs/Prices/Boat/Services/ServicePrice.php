<?php

namespace App\Libs\Prices\Boat\Services;

use App\Models\Boat;
use App\Libs\Prices\Price;
use App\Models\ConfigPriceType;

class ServicePrice
{
    protected $price;
    protected $targetValue;

    public function __construct(
        protected Boat            $boat,
        protected string          $modus,
        protected ConfigPriceType $priceType,
        protected float           $pricePerUntit
    ) {
        switch ($this->priceType->type) {
            case 'area':
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
            case 'length':
                $this->targetValue = $this->boat->length;
                break;
            case 'weight':
                $this->targetValue = $this->boat->weight;
                break;
            default:
                break;
        }

        if($this->targetValue) {
            $this->price = new Price($this->targetValue * $this->pricePerUntit);
        }
    }

    public function getPrice() {
        if($this->price && $this->price instanceof Price) {
            return $this->price->getValue();
        }
        return 0;
    }
}
