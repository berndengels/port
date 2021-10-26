<?php
namespace App\Libs\Prices;

use App\Libs\Prices\BoatGuest\Electric;
use App\Libs\Prices\BoatGuest\Individual;
use App\Libs\Prices\BoatGuest\Persons;
use Illuminate\Http\Request;
use App\Libs\Prices\BoatGuest\Base;

class BoatGuestPrice extends PriceCalculator
{
    protected static $priceBase;
    protected static $pricePersons;
    protected static $priceElectric;
    protected static $priceIndividual;

    public function getPrice(Request $request): array
    {
        $personsCount       = (int) $request->post('persons', 0);
        $length             = (int) $request->post('length', 0);
        $individualPrice    = (int) $request->post('individual_price', 0) ;
        $hasElectric        = (bool) $request->post('electric', false);

        $base       = new Base($length);
        $individual = new Individual($individualPrice);
        $persons    = new Persons($personsCount);
        $electric   = new Electric($hasElectric);
        $dCount     = static::$daysCount;
        $dPeriod    = static::$_datePeriod;

        static::$priceBase          = $base->setDaysCount($dCount)->addPrice($dPeriod);
        static::$pricePersons       = $persons->setDaysCount($dCount)->addPrice($dPeriod);
        static::$priceElectric      = $electric->setDaysCount($dCount)->addPrice($dPeriod);
        static::$priceIndividual    = $individual->addPrice();
        static::$total = 0;

        if(static::$priceIndividual > 0) {
            $price = $this->set(static::$priceIndividual);
        } else {
            $price = $this
                ->add(static::$priceBase)
                ->add(static::$pricePersons)
                ->add(static::$priceElectric)
            ;
        }
        return $price->formatResult();
    }
}
