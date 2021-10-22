<?php
namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Libs\CaravanPriceCalculator;
use Database\Factories\Ext\MainFactory;

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
        $randIndex  = rand(0, $max);
        $persons    = rand(1, 4);
        $electric   = rand(0, 1);
        $priceData  = (new CaravanPriceCalculator())->getPrice(Carbon::create($from), Carbon::create($until), $caravans[$randIndex]->carlength, $persons, $electric);
        $price      = $priceData['total'];
        $prices     = json_encode($priceData['prices']);

        return [
            'caravan_id'    => $caravans[$randIndex]->id,
            'from'          => $from,
            'until'         => $until,
            'persons'       => $persons,
            'electric'      => $electric,
            'price'         => $price,
            'prices'        => $prices,
        ];
    }
}
