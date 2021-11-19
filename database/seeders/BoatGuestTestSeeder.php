<?php
namespace Database\Seeders;

use App\Helper\DateHelper;
use App\Helper\RequestHelper;
use App\Libs\Prices\BoatGuestPrice;
use App\Models\BoatGuest;
use App\Models\BoatGuestDates;
use Carbon\Carbon;
use Database\Seeders\Ext\MainTestSeeder;
use http\Client\Request;

class BoatGuestTestSeeder extends MainTestSeeder
{
    protected $table = 'boat_guests';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoatGuest::factory()
            ->hasDates(3, function (array $attributes, BoatGuest $boat) {
                $randomDateEnd = Carbon::today()->addMonths(5)->format('Y-m-d');
                $from  = Carbon::create(DateHelper::randomDate('2020-05-01', $randomDateEnd,'Y-m-d'));
                $until = $from->copy()->addDays(rand(1,7));
                $price = (new BoatGuestPrice($from, $until, $boat))->getPrice(RequestHelper::build());

                return [
                    'boat_guest_id' => $boat->id,
                    'from'          => $from,
                    'until'         => $until,
                    'price'         => $price['total'],
                    'prices'        => json_encode($price),
                ];
            })
            ->count($this->count)
            ->create()
        ;
    }
}
