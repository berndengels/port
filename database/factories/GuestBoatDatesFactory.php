<?php
namespace Database\Factories;

use Carbon\Carbon;
use Database\Data\BerthData;
use Database\Factories\Ext\MainFactory;

class GuestBoatDatesFactory extends MainFactory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $endDate    = Carbon::today()->addMonths(5)->format('Y-m-d');
        $from       = $this->randomDate('2020-05-01', $endDate,'Y-m-d');
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $berths     = BerthData::$data;
        $berth      = $berths[rand(20, count($berths) - 1)];
        return [
            'berth_id'  => $berth['id'],
            'from'      => $from,
            'until'     => $until,
            'price'     => 0,
            'prices'    => '{}',
        ];
    }
}
