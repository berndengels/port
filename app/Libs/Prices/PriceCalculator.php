<?php
namespace App\Libs\Prices;

use DatePeriod;
use Carbon\Carbon;
use ReflectionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

    public function __construct(Carbon $from = null,  Carbon $until = null, protected $model = null)
    {
        static::$from           = $from;
        static::$until          = $until;
        static::$_datePeriod    = ($from && $until) ? $from->toPeriod($until)->toDatePeriod() : null;
        static::$daysCount      = static::$_datePeriod ? iterator_count(static::$_datePeriod) : 0;
    }

    public function add(Price $price): self
    {
        static::$total += (float) $price->getValue();
        return $this;
    }

    protected function formatResult(array $dailyPrices): array
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
        $prices['dailyPrices'] = $dailyPrices;
        return $prices;
    }

    protected abstract function registerAddPriceClasses(): Collection;

//    protected abstract function registerSetPriceClasses(): Collection;

    protected abstract function params(): Collection;

//    public abstract function getPrice(Request $request): array;
    public function getPrice(Request $request): array
    {
        $dCount     = static::$daysCount;
        $dPeriod    = static::$_datePeriod;
        static::$total = 0;

        foreach ($this->registerAddPriceClasses() as $class) {
            if(class_exists($class)) {
                $basename  = class_basename($class);
                $staticProp = 'price' . $basename;
                $rClass     = new ReflectionClass($class);

                $obj = $this->getObject($request, $class, $rClass);

                switch (true) {
                    case $rClass->implementsInterface(IDailyPrice::class):
                        static::$$staticProp = $obj->setDaysCount($dCount)->addPrice($dPeriod);
                        break;
                    case $rClass->implementsInterface(IPrice::class):
                    default:
                        static::$$staticProp = $obj->addPrice();
                        break;
                }
                $this->add(static::$$staticProp);
            }
        }
        return $this->formatResult($obj::$dailyPrices);
    }

    protected function getObject(Request $request, string $class, ReflectionClass $rClass): object {
        $constructParams = [];

        $params = [];

        foreach ($this->params() as $item) {
            if($this->model && $this->model->getAttribute($item)) {
                $params[$item] = $this->model->{$item};
            } else {
                $params[$item] = $request->post($item);
            }
        }

        $cParams    = $rClass->getConstructor()->getParameters();
        /**
         * @var $pNames Collection
         */
        $pNames     = collect($cParams)->map->name;

        foreach ($pNames as $name) {
            switch ($name) {
                case 'from':
                    $constructParams[] = static::$from;
                    break;
                case 'until':
                    $constructParams[] = static::$until;
                    break;
                default:
                    $constructParams[] = $params[$name] ?? null;
                    break;
            }
        }

        return new $class(...$constructParams);
    }
}
