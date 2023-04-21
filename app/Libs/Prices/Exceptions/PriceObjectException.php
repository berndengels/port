<?php
namespace App\Libs\Prices\Exceptions;

use UnexpectedValueException;

/**
 * PriceObjectException
 */
class PriceObjectException extends UnexpectedValueException
{
    /**
     * @param  $type
     * @return static
     */
    public static function wrongType($type)
    {
        return new static("Wrong price object type ($type)");
    }

    /**
     * @param  $value
     * @return static
     */
    public static function wrongValue($value)
    {
        return new static("Wrong price object value ($value)");
    }
}
