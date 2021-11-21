<?php
namespace Database\Seeders;

use App\Helper\DateHelper;
use App\Helper\RequestHelper;
use App\Libs\Prices\BoatGuestPrice;
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
    protected $count = 300;
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
                $from  = Carbon::create(DateHelper::randomDate('2020-05-01', $randomDateEnd,'Y-m-d'));
                $until = $from->copy()->addDays(rand(1,7));
                $electric   = mt_rand(0,1);
                $persons    = mt_rand(1,4);
                $params = [
                    'electric'      => $electric,
                    'persons'       => $persons,
                ];

                $price = (new CaravanPrice($from, $until, $caravan))->getPrice(RequestHelper::build($params));

                return $params + [
                    'caravan_id' => $caravan->id,
                    'from'          => $from,
                    'until'         => $until,
                    'price'         => $price['total'],
                    'prices'        => json_encode($price),
                ];
            })
            ->count($this->count)
            ->create();
    }
}
