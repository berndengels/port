<?php
namespace Database\Factories;

use App\Libs\Prices\CaravanPrice;
use Carbon\Carbon;
use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Libs\CaravanPriceCalculator;
use Database\Factories\Ext\MainFactory;
use Illuminate\Http\Request;

/**
 *
 */
class CaravanDatesFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     * @var string
     */
    protected $model = CaravanDates::class;
    /**
     * The name of the factory's corresponding parent model.
     * @var string
     */
    protected $parentModel = Caravan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $caravans = $this->getParents(['id','carlength']);
        $max = max($caravans->keys()->toArray()) - 1;
        $randomDateEnd = Carbon::today()->addMonths(1)->format('Y-m-d');
        $from       = $this->randomDate('2020-01-01', $randomDateEnd,'Y-m-d');
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $from       = Carbon::create($from);
        $randIndex  = rand(0, $max);
        $persons    = rand(1, 4);
        $electric   = rand(0, 1);
        $caravan    = $caravans[$randIndex];

        $params = [
            'from'      => $from,
            'until'     => $until,
            'carlength' => $caravan->carlength,
            'persons'   => $persons,
            'electric'  => $electric,
            'day_price' => 0,
        ];

        $request = new Request();
        $request->request->add($params);

        $priceData  = (new CaravanPrice($from, $until))->getPrice($request);
        $price      = $priceData['total'];
        $prices     = json_encode($priceData);

        return [
            'caravan_id'    => $caravan->id,
            'from'          => $from,
            'until'         => $until,
            'persons'       => $persons,
            'electric'      => $electric,
            'price'         => $price,
            'prices'        => $prices,
        ];
    }
}
