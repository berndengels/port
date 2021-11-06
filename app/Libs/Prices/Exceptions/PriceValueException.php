<?php
namespace App\Libs\Prices\Exceptions;

use UnexpectedValueException;

/**
 * PriceValueException
 */
class PriceValueException extends UnexpectedValueException
{
    /**
     * @param  $type
     * @return static
     */
    public static function wrongType($type)
    {
        return new static("Wrong price value type ($type), expect: int|float");
    }

    /**
     * @param  $value
     * @return static
     */
    public static function wrongValue($value)
    {
        return new static("Wrong price value ($value), expect: value >= 0");
    }
}
