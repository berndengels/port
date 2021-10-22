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
        $parents    = $this->getParents();
        $max        = max($parents->keys()->toArray()) - 1;
        $randomDateEnd = Carbon::today()->addMonths(5)->format('Y-m-d');
        $from       = $this->randomDate('2020-05-01', $randomDateEnd,'Y-m-d');
        $until      = Carbon::create($from)->addDays(rand(1,7));
        $randIndex  = rand(0, $max);
        $length     = $parents[$randIndex]->length;
        $price      = config('port.prices.boat_guest.price_per_meter') * $length;

        return [
            'boat_guest_id'  => $parents[$randIndex]->id,
            'from'      => $from,
            'until'     => $until,
//            'persons'   => 0,
//            'electric'  => 0,
            'price'     => $price,
        ];
    }
}
