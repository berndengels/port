<?php
namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\GuestBoat;
use App\Helper\DateHelper;
use App\Helper\RequestHelper;
use App\Libs\Prices\GuestBoatPrice;
use Database\Seeders\Ext\MainTestSeeder;

class GuestBoatSeeder extends MainTestSeeder
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
                $from       = Carbon::create(DateHelper::randomDate('2020-05-01', $randomDateEnd,'Y-m-d'));
                $until      = $from->copy()->addDays(rand(1,7));
//                $electric   = (bool) rand(0,1);
//                $persons    = rand(1,4);
                $electric   = false;
                $persons    = 2;

                $price = (new GuestBoatPrice($from, $until, $boat))->getPrice(RequestHelper::build([
                    'length'    => rand(7, 12),
                    'electric'  => $electric,
                    'persons'   => $persons,
                ]));

                return [
                    'guest_boat_id' => $boat->id,
                    'from'          => $from,
                    'until'         => $until,
                    'electric'      => $electric,
                    'persons'       => $persons,
                    'price'         => $price['total'],
                    'prices'        => json_encode($price),
                ];
            })
            ->count($this->count)
            ->create()
        ;
    }
}
