<?php

namespace App\Libs\Calculations\Boat\Material;

use App\Models\Boat;

class Quantity
{
    /**
     * @var int|float
     */
    protected $quantity;
    protected $targetValue;

    public function __construct(
        protected Boat $boat,
        protected string $modus,
        protected float $fertility,
        protected string $fertilityPer,
        protected string $fertilityUnit
    )
    {
        switch($this->fertilityUnit) {
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
            default:
                $this->targetValue = $this->boat->length;
                break;
        }
        if($this->targetValue) {
            $this->quantity = $this->targetValue / $this->fertility;
        }
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
