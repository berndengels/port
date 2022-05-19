<?php
namespace App\Libs\Prices;

use DatePeriod;
use Carbon\Carbon;
use ReflectionClass;
use Illuminate\Http\Request;
use App\Traits\Models\HasTaxRate;
use Illuminate\Support\Collection;

abstract class PriceCalculator
{
    use HasTaxRate;
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

    public function __construct(?Carbon $from = null, ?Carbon $until = null, protected $model = null)
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

    protected function formatResult(array $props): array
    {
        $prices = [];
        foreach ($props as $prop => $val) {
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

    abstract protected function registerAddPriceClasses(): Collection;

    abstract protected function params(): Collection;

//    public abstract function getPrice(Request $request): array;
    public function getPrice(Request $request): array
    {
        $dCount     = static::$daysCount;
        $dPeriod    = static::$_datePeriod;
        static::$total = 0;
        $props = [];

        foreach ($this->registerAddPriceClasses() as $class) {
            if(class_exists($class)) {
                $basename   = class_basename($class);
                $staticProp = 'price' . $basename;
                $rClass     = new ReflectionClass($class);
                $obj        = $this->getObject($request, $class, $rClass);

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
                $props[$staticProp] = static::$$staticProp;

                if( property_exists($obj, 'dailyPrices') ) {
                    $props['dailyPrices'] = $obj::$dailyPrices;
                }
            }
        }

        $props['days'] = static::$daysCount;

        if(config('port.prices.tax.enabled')) {
            $props['tax'] = $this->taxRate();
            $props['netto'] = $this->nettoPrice(static::$total);
        }
        $props['total'] = static::$total;

//        $props['dailyPrices'] = $obj::$dailyPrices;

        return $this->formatResult($props);
    }

    protected function getObject(Request $request, string $class, ReflectionClass $rClass): object {
        $params = [];
        $constructParams = [];

        foreach ($this->params() as $item) {
            if($this->model && $this->model->getAttribute($item)) {
                $params[$item] = $this->model->{$item};
            } else {
                $params[$item] = $request->post($item);
            }
        }

        $cParams = $rClass->getConstructor()->getParameters();
        /**
         * @var $pNames Collection
         */
        $pNames = collect($cParams)->map->name;

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
