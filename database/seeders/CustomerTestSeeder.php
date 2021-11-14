<?php
namespace Database\Seeders;

use App\Models\Boat;
use App\Models\Role;
use App\Models\Customer;
use App\Models\BoatDates;
use App\Models\ServiceRequest;
use Database\Seeders\Ext\MainTestSeeder;

class CustomerTestSeeder extends MainTestSeeder
{
    protected $table = 'customers';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::factory()
            ->has(Boat::factory()
//                ->has(ServiceRequest::factory()->hasServices(3)->count(2))
                ->has(BoatDates::factory()->count(3),'dates')->count(1),'boats')
            ->count($this->count)
            ->create()
        ;

        Role::getModel()->refresh();

        if(Role::whereName('boat')->first()) {
            $customers->each(function (Customer $customer) {
                $customer->assignRole('boat');
            });
        }
    }
}
