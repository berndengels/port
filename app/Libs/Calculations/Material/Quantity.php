<?php

namespace App\Libs\Calculations\Material;

class Quantity
{
    /**
     * @var int|float
     */
    protected $quantity;

    public function __construct(
        protected string $tagetValue,
        protected float $fertility,
    )
    {
        $this->quantity = $this->tagetValue / $this->fertility;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
