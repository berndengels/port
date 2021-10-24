<?php
namespace App\Libs\Prices;

use Illuminate\Http\Request;
use App\Libs\Prices\Caravan\Base;
use App\Libs\Prices\Caravan\Persons;
use App\Libs\Prices\Caravan\Electric;
use App\Libs\Prices\Caravan\Individual;

class CaravanPrice extends PriceCalculator
{
    protected static $pricePerDayElectric = 0;
    protected static $pricePerDayPersons = 0;
    protected static $priceBase = 0;
    protected static $priceIndividual = 0;

    public function getPrice(Request $request)
    {
        $personsCount   = $request->post('persons');
        $carLength      = $request->post('carlength');
        $dayPrice       = !empty($request->post('day_price')) ? (int) $request->post('day_price') : null;
        $hasElectric    = (bool) $request->post('electric', false);

        $base       = new Base($carLength);
        $persons    = new Persons($personsCount);
        $electric   = new Electric($hasElectric);
        $individual = new Individual($dayPrice);

        static::$priceBase              = $base->addPrice(parent::$_datePeriod);
        static::$pricePerDayPersons     = $persons->addPrice(parent::$_datePeriod);
        static::$pricePerDayElectric    = $electric->addPrice(parent::$_datePeriod);
        static::$priceIndividual        = $individual->addPrice(parent::$_datePeriod);
        static::$total = 0;

        $result = $this
            ->add(static::$priceBase)
            ->add(static::$pricePerDayPersons)
            ->add(static::$pricePerDayElectric)
            ->set(static::$priceIndividual)
            ->formatResult()
        ;
        return $result;
    }
}
