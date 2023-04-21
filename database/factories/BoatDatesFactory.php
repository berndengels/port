<?php
namespace Database\Factories;

use Carbon\Carbon;
use Database\Factories\Ext\MainFactory;

class BoatDatesFactory extends MainFactory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $modi       = ['summer','winter'];
        $endDate    = Carbon::today()->addMonths(1)->format('Y-m-d');
        $from       = $this->randomDate('2020-01-01', $endDate);
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $from       = Carbon::create($from);
        $modus      = $modi[rand(0,1)];

        return [
            'modus'     => $modus,
            'from'      => $from,
            'until'     => $until,
            'price'     => 0,
            'prices'    => '{}',
        ];
    }
}
