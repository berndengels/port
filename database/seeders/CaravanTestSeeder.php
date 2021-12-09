<?php
namespace Database\Seeders;

use App\Helper\DateHelper;
use App\Helper\RequestHelper;
use App\Libs\Prices\GuestBoatPrice;
use App\Libs\Prices\CaravanPrice;
use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Models\Country;
use Carbon\Carbon;
use Database\Seeders\Ext\MainTestSeeder;
use Illuminate\Support\Facades\Schema;

class CaravanTestSeeder extends MainTestSeeder
{
    protected $table = 'caravans';
    protected $count = 50;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Caravan::factory()
            ->hasDates(3, function(array $attribures, Caravan $caravan) {
                $randomDateEnd = Carbon::today()->addMonths(5)->format('Y-m-d');
                $from       = Carbon::create(DateHelper::randomDate('2020-05-01', $randomDateEnd,'Y-m-d'));
                $until      = $from->copy()->addDays(rand(1,7));
                $electric   = (bool) rand(0,1);
                $persons    = rand(1,4);

                $price = (new CaravanPrice($from, $until, $caravan))->getPrice(RequestHelper::build([
                    'carlength'     => rand(6, 10),
                    'electric'      => $electric,
                    'persons'       => $persons,
                ]));

                return [
                    'caravan_id' => $caravan->id,
                    'from'          => $from,
                    'until'         => $until,
                    'electric'      => $electric,
                    'persons'       => $persons,
                    'price'         => $price['total'],
                    'prices'        => json_encode($price),
                ];
            })
            ->count($this->count)
            ->create();
    }
}
