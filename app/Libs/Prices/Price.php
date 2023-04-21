<?php
namespace App\Libs\Prices;

use App\Libs\Prices\Exceptions\PriceValueException;

/**
 * Price as Object
 */
class Price
{
    private $validTypes = ['integer', 'double'];
    /**
     * @param int|float $value
     */
    public function __construct(protected float $value = 0)
    {
        $type = gettype($value);

        if(!in_array($type, $this->validTypes)) {
            throw PriceValueException::wrongType($type);
        }
        if($this->value < 0) {
            throw PriceValueException::wrongValue($this->value);
        }
    }

    /**
     * @return float|int
     */
    public function getValue(): float|int
    {
        return round($this->value, 2);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) round($this->value, 2);
    }
}
