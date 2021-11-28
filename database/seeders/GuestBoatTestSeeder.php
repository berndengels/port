<?php
namespace Database\Seeders;

use App\Helper\DateHelper;
use App\Helper\RequestHelper;
use App\Libs\Prices\GuestBoatPrice;
use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use Carbon\Carbon;
use Database\Seeders\Ext\MainTestSeeder;
use http\Client\Request;

class GuestBoatTestSeeder extends MainTestSeeder
{
    protected $table = 'boat_guests';
    protected $count = 300;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GuestBoat::factory()
            ->hasDates(3, function (array $attributes, GuestBoat $boat) {
                $randomDateEnd = Carbon::today()->addMonths(5)->format('Y-m-d');
                $from  = Carbon::create(DateHelper::randomDate('2020-05-01', $randomDateEnd,'Y-m-d'));
                $until = $from->copy()->addDays(rand(1,7));
                $price = (new GuestBoatPrice($from, $until, $boat))->getPrice(RequestHelper::build());

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
