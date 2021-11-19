<?php
namespace App\Libs\Prices;

use App\Libs\Prices\BoatGuest\Electric;
use App\Libs\Prices\BoatGuest\Individual;
use App\Libs\Prices\BoatGuest\Persons;
use App\Models\BoatGuest;
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
        if($this->model && $this->model instanceof BoatGuest) {
            $length = (int) $this->model->length;
        } else {
            $length = (int) $request->post('length', 0);
        }
        $individualPrice    = (int) $request->post('day_price', 0);

        $base       = new Base($length);
        $individual = new Individual($individualPrice);
        $dCount     = static::$daysCount;
        $dPeriod    = static::$_datePeriod;

        static::$priceBase          = $base->setDaysCount($dCount)->addPrice($dPeriod);
        static::$priceIndividual    = $individual->addPrice();
        static::$total = 0;

        $price = $this
            ->add(static::$priceBase)
            ->set(static::$priceIndividual);
        return $price->formatResult();
    }
}
