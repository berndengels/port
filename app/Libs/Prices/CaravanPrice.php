<?php
namespace App\Libs\Prices;

use Illuminate\Http\Request;
use App\Libs\Prices\Caravan\Base;
use App\Libs\Prices\Caravan\Persons;
use App\Libs\Prices\Caravan\Electric;
use App\Libs\Prices\Caravan\Individual;

class CaravanPrice extends PriceCalculator
{
    protected static $priceElectric = 0;
    protected static $pricePersons = 0;
    protected static $priceBase = 0;
    protected static $priceIndividual = 0;

    public function getPrice(Request $request)
    {
        $personsCount       = $request->post('persons');
        $carLength          = $request->post('carlength');
        $individualPrice    = (int) $request->post('day_price', 0);
        $hasElectric        = (bool) $request->post('electric', false);

        $base       = new Base($carLength);
        $persons    = new Persons($personsCount);
        $electric   = new Electric($hasElectric);
        $individual = new Individual($individualPrice);

        static::$priceBase        = $base->addPrice(parent::$_datePeriod);
        static::$pricePersons     = $persons->addPrice(parent::$_datePeriod);
        static::$priceElectric    = $electric->addPrice(parent::$_datePeriod);
        static::$priceIndividual  = $individual->addPrice();
        static::$total = 0;

        $result = $this
            ->add(static::$priceBase)
            ->add(static::$pricePersons)
            ->add(static::$priceElectric)
            ->set(static::$priceIndividual)
            ->formatResult()
        ;
        return $result;
    }
}
