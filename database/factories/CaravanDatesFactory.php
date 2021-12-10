<?php
namespace Database\Factories;

use Carbon\Carbon;
use App\Libs\CaravanPriceCalculator;
use Database\Factories\Ext\MainFactory;

/**
 *
 */
class CaravanDatesFactory extends MainFactory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $endDate    = Carbon::today()->addMonths(1)->format('Y-m-d');
        $from       = $this->randomDate('2020-01-01', $endDate,'Y-m-d');
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $from       = Carbon::create($from);
//        $persons    = rand(1, 4);
//        $electric   = rand(0, 1);
        $persons    = 2;
        $electric   = 0;

        return [
            'from'          => $from,
            'until'         => $until,
            'persons'       => $persons,
            'electric'      => $electric,
            'price'         => 0,
            'prices'        => '{}',
        ];
    }
}
