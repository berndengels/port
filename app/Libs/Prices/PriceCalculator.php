<?php
namespace App\Libs\Prices;

use App\Models\ConfigSetting;
use DatePeriod;
use Carbon\Carbon;
use ReflectionClass;
use Illuminate\Http\Request;
use App\Traits\Models\HasTaxRate;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Libs\Prices\Exceptions\PriceObjectException;

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
    protected $useTax = false;
    protected $tax;
    protected $taxPrice;

    public function __construct(
        ?Carbon $from = null,
        ?Carbon $until = null,
        protected ?Model $model = null)
    {
        $settings = ConfigSetting::first();
        $this->useTax           = (bool) $settings->use_tax;
        $this->tax              = $settings->tax;
        static::$from           = $from;
        static::$until          = $until;
        static::$_datePeriod    = ($from && $until) ? $from->toPeriod($until)->toDatePeriod() : null;
        static::$daysCount      = static::$_datePeriod ? iterator_count(static::$_datePeriod) : 0;
    }

    abstract protected function registerAddPriceClasses(): Collection;

    abstract protected function params(): Collection;

//    public abstract function getPrice(Request $request): array;
    public function getPrice(Request $request)
    {
        static::$total = 0;
        $props = $this->getObjectProperties($this->registerAddPriceClasses(), $request);
        $props['days'] = static::$daysCount;

        if($this->useTax) {
            $props['tax']   = $this->tax;
            $props['netto'] = self::nettoPriceRounded(static::$total);
            $props['taxPrice'] = round(static::$total - $props['netto'], 2);
        }
        $props['total'] = static::$total;

//        $props['dailyPrices'] = $obj::$dailyPrices;

        return $this->formatResult($props);
    }

    protected function getObject(Request $request, string $class, ReflectionClass $rClass): object|null {
        $params = [];
        $args = [];
        try {
            foreach ($this->params() as $item) {
                if($this->model && $this->model->getAttribute($item)) {
                    $params[$item] = $this->model->{$item};
                } else {
					if($request->has($item)) {
						$params[$item] = $request->post($item);
					}
                }
            }
            $cParams = $rClass->getConstructor()->getParameters();
            /**
             * @var $pNames Collection
             */

			foreach ($cParams as $p) {
				$name = $p->getName();
				$type = $p->getType();

				switch ($name) {
					case 'from':
						$args[] = static::$from;
						break;
					case 'until':
						$args[] = static::$until;
						break;
					default:
						if(isset($params[$name])) {
							$args[] = $params[$name] ?? null;
						}
						break;
				}
			}

            if($this->model instanceof $type) {
                $args[] = $this->model;
            }

            return new $class(...$args);
        } catch(\Exception $e) {
            throw new PriceObjectException($e);
        }
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

    public function add(Price $price): self
    {
        static::$total += (float) $price->getValue();
        return $this;
    }

    private function getObjectProperties(Collection $registredClasses, Request $request)
    {
        $dCount     = static::$daysCount;
        $dPeriod    = static::$_datePeriod;
        $props = [];

        foreach ($registredClasses as $class) {
            if(class_exists($class)) {
                $basename   = class_basename($class);
                $staticProp = 'price' . $basename;
                $rClass     = new ReflectionClass($class);

                try {
                    $obj = $this->getObject($request, $class, $rClass);
                } catch(PriceObjectException $e) {
                    return response()->json(['error' => $e->getMessage()]);
                } catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()]);
                }

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

        return $props;
    }
}
