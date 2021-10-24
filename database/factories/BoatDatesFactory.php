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
    protected $parentModel = Boat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $modi       = ['guest','permanent'];
        $boats      = $this->getParents();
        $max        = max($boats->keys()->toArray()) - 1;
        $randomDateEnd = Carbon::today()->addMonths(1)->format('Y-m-d');
        $from       = $this->randomDate('2020-01-01', $randomDateEnd,'Y-m-d');
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $from       = Carbon::create($from);
        $randIndex  = rand(0, $max);
        $boat       = $boats[$randIndex];
        $modus      = $modi[rand(0,1)];
        $boatType   = $boat->boat_type;
        $length     = $boat->length;
        $width      = $boat->width;
        $weight     = $boat->weight;
        $mastLength = $boat->mast_length;
        $mastWeight = $boat->mast_weight;
        $crane      = (bool) rand(0,1);
        $mastCrane  = (bool) rand(0,1);
        $cleaning   = (bool) rand(0,1);

        $params = [
            'from'          => $from,
            'until'         => $until,
            'modus'         => $modus,
            'length'        => $length,
            'width'         => $width,
            'weight'        => $weight,
            'crane'         => $crane,
            'mast_crane'    => $mastCrane,
            'cleaning'      => $cleaning,
        ];

        if('sail' === $boatType) {
            $params = array_merge($params,[
                'mast_length'   => $mastLength,
                'mast_weight'   => $mastWeight,
            ]);
        }

        $request = new Request();
        $request->request->add($params);
        $priceData  = (new BoatPrice($from, $until))->getPrice($request);

        $price      = $priceData['total'];
        $prices     = json_encode($priceData);

        return [
            'boat_id'   => $boats[$randIndex]->id,
            'modus'     => $modus,
            'from'      => $from,
            'until'     => $until,
            'price'     => $price,
            'prices'    => $prices,
        ];
    }
}
