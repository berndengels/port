<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Boat;
use App\Models\Role;
use App\Models\Customer;
use App\Helper\DateHelper;
use App\Helper\RequestHelper;
use App\Libs\Prices\BoatPrice;
use Database\Seeders\Ext\MainTestSeeder;

class CustomerSeeder extends MainTestSeeder
{
    protected $table = 'customers';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = Customer::factory()->create();
        Boat::factory()
            ->hasDates(10, function (array $attributes, Boat $boat) {
                $randomDateEnd = Carbon::today()->addMonths(5)->format('Y-m-d');
                $from  = Carbon::create(DateHelper::randomDate('2020-05-01', $randomDateEnd,'Y-m-d'));
                $until = $from->copy()->addMonths(rand(4,8));
                $modus  = ['summer','winter'][mt_rand(0,1)];

                $price = (new BoatPrice(null, null, $boat))->getPrice(RequestHelper::build([
                    'modus'         => $modus,
                    'cleaning'      => (bool) rand(0,1),
                    'crane'         => true,
                    'mast_crane'    => false,
                    'transport'     => true,
                ]));
                return [
                    'boat_id'       => $boat->id,
                    'from'          => $from,
                    'until'         => $until,
                    'modus'         => $modus,
                    'price'         => $price['total'],
                    'prices'        => json_encode($price),
                ];
            })
            ->hasServiceRequests(2)
            ->count(1)
            ->for($customer)
            ->create()
        ;

        Role::getModel()->refresh();

        if(Role::whereName('boat')->first()) {
            $customer->each(function (Customer $customer) {
                $customer->assignRole('boat');
            });
        }
/*
        $customers = Customer::randomFactory()->count(100)->create();
        foreach ($customers as $customer) {
            Boat::factory()
                ->hasDates(4, function (array $attributes, Boat $boat) {
                    $randomDateEnd = Carbon::today()->addMonths(5)->format('Y-m-d');
                    $from  = Carbon::create(DateHelper::randomDate('2020-05-01', $randomDateEnd,'Y-m-d'));
                    $until = $from->copy()->addMonths(rand(4,8));
                    $modus  = ['saison','winter'][mt_rand(0,1)];
                    $params = [
                        'cleaning'      => mt_rand(0,1),
                        'crane'         => 1,
                        'mast_crane'    => mt_rand(0,1),
                        'modus'         => $modus,
                    ];
                    $price = (new BoatPrice(null, null, $boat))->getPrice(RequestHelper::build($params));
                    return [
                        'boat_id' => $boat->id,
                        'from'          => $from,
                        'until'         => $until,
                        'modus'         => $modus,
                        'price'         => $price['total'],
                        'prices'        => json_encode($price),
                    ];
                })
                ->hasServiceRequests(2)
                ->count(1)
                ->for($customer)
                ->create()
            ;

            Role::getModel()->refresh();

            if(Role::whereName('boat')->first()) {
                $customer->each(function (Customer $customer) {
                    $customer->assignRole('boat');
                });
            }
        }
*/
    }
}
