<?php
namespace Database\Factories;

use Carbon\Carbon;
use App\Models\BoatGuest;
use App\Models\BoatGuestDates;
use Database\Factories\Ext\MainFactory;

class BoatGuestDatesFactory extends MainFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BoatGuestDates::class;
    protected $parentModel = BoatGuest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomDateEnd = Carbon::today()->addMonths(5)->format('Y-m-d');
        $from  = $this->randomDate('2020-05-01', $randomDateEnd,'Y-m-d');
        $until = Carbon::create($from)->addDays(rand(1,7));

        return [
            'from'      => $from,
            'until'     => $until,
//            'persons'   => 0,
//            'electric'  => 0,
            'price'     => 0,
            'prices'    => '{}',
        ];
    }
}
