<?php
namespace App\Libs\Prices;

use DatePeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;

abstract class PriceCalculator
{
    /**
     * @var DatePeriod
     */
    protected static $daysCount;
    protected static $from;
    protected static $until;
    protected static $_datePeriod;
    protected static $total = 0;

    public function __construct(Carbon $from, Carbon $until)
    {
        self::$from         = $from;
        self::$until        = $until;
        self::$_datePeriod  = $from->toPeriod($until)->toDatePeriod();
        self::$daysCount    = iterator_count(self::$_datePeriod);
    }

    public function add($price) {
        static::$total += $price;
        return $this;
    }

    public function set($price) {
        if($price > 0) {
            static::$total = $price;
        }
        return $this;
    }

    protected function formatResult()
    {
        $vars = get_class_vars(static::class);
        $prices = [];
        foreach ($vars as $prop => $val) {
            if(false === strpos($prop, '_', 0)) {
                if($val instanceof Carbon) {
                    $val = $val->format('d.m.Y');
                }
                $prices[$prop] = $val;
            }
        }
        return [
            'total' => static::$total,
            'prices' => $prices,
        ];
    }

    public abstract function getPrice(Request $request);
}
