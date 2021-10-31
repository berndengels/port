<?php
namespace Database\Factories;

use App\Libs\BoatPriceCalculator;
use App\Libs\CaravanPriceCalculator;
use App\Libs\Prices\BoatPrice;
use App\Models\Boat;
use App\Models\BoatDates;
use Carbon\Carbon;
use Database\Factories\Ext\MainFactory;
use Illuminate\Http\Request;

class BoatDatesFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BoatDates::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $modi       = ['saison','winter'];
        $randomDateEnd = Carbon::today()->addMonths(1)->format('Y-m-d');
        $from       = $this->randomDate('2020-01-01', $randomDateEnd,'Y-m-d');
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $from       = Carbon::create($from);
        $modus      = $modi[rand(0,1)];
        $crane      = (bool) rand(0,1);
        $mastCrane  = (bool) rand(0,1);
        $cleaning   = (bool) rand(0,1);

/*
        $params = [
            'from'          => $from,
            'until'         => $until,
            'modus'         => $modus,
            'crane'         => $crane,
            'mast_crane'    => $mastCrane,
            'cleaning'      => $cleaning,
        ];
        $request = new Request();
        $request->request->add($params);
        $priceData  = (new BoatPrice($from, $until))->getPrice($request);

        $price      = $priceData['total'];
        $prices     = json_encode($priceData);
*/
        return [
            'modus'     => $modus,
            'from'      => $from,
            'until'     => $until,
            'price'     => 0,
            'prices'    => '{}',
        ];
    }
}
