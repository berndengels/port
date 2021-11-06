<?php
namespace App\Libs\Prices;

use DatePeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;

abstract class PriceCalculator
{
    /**
     * @var Carbon
     */
    protected static $from;
    /**
     * @var Carbon
     */
    protected static $until;
    /**
     * @var int
     */
    protected static $daysCount;
    /**
     * @var DatePeriod
     */
    protected static $_datePeriod;
    /**
     * @var int
     */
    protected static $total = 0;

    public function __construct(Carbon $from = null,  Carbon $until = null)
    {
        static::$from           = $from;
        static::$until          = $until;
        static::$_datePeriod    = ($from && $until) ? $from->toPeriod($until)->toDatePeriod() : null;
        static::$daysCount      = static::$_datePeriod ? iterator_count(static::$_datePeriod) : 0;
    }

    public function add(Price $price): self {
        static::$total += (float) $price->getValue();
        return $this;
    }

    public function set(Price $price): self {
        $value = $price->getValue();
        if($value > 0) {
            static::$total = (float) $value;
        }
        return $this;
    }

    protected function formatResult(): array
    {
        $vars = get_class_vars(static::class);
        $prices = [];
        foreach ($vars as $prop => $val) {
            if(false === strpos($prop, '_', 0)) {
                if($val instanceof Carbon) {
                    $val = $val->format('d.m.Y');
                }
                if($val instanceof Price) {
                    $val = (float) $val->getValue();
                }
                $prices[$prop] = $val;
            }
        }
        return $prices;
    }

    public abstract function getPrice(Request $request): array;
}
