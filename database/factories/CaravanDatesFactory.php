<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Libs\CaravanPriceCalculator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 *
 */
class CaravanDatesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaravanDates::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $caravans = $this->getCaravans();
        $max = max($caravans->keys()->toArray()) - 1;
        $randomDateEnd = Carbon::today()->addMonths(1)->format('Y-m-d');
        $from       = $this->randomDate('2016-01-01', $randomDateEnd,'Y-m-d');
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $randIndex  = rand(0, $max);
        $persons    = rand(1, 4);
        $electric   = rand(0, 1);
        $priceData  = CaravanPriceCalculator::getPrice(Carbon::create($from), Carbon::create($until), $caravans[$randIndex]->carlength, $persons, $electric);
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

    /**
     * @return Collection
     */
    private function getCaravans() {
        return Caravan::all(['id','carlength']);
    }

    /**
     * Method to generate random date between two dates
     * @param $sStartDate
     * @param $sEndDate
     * @param string $sFormat
     * @return bool|string
     */
    private function randomDate($sStartDate, $sEndDate, $sFormat = 'Y-m-d H:i:s') {
        // Convert the supplied date to timestamp
        $fMin = strtotime($sStartDate);
        $fMax = strtotime($sEndDate);

        // Generate a random number from the start and end dates
        $fVal = mt_rand($fMin, $fMax);

        // Convert back to the specified date format
        return date($sFormat, $fVal);
    }
}
