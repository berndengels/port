<?php
namespace Database\Seeders;

use App\Models\Boat;
use App\Models\BoatDates;
use App\Models\Role;
use App\Models\Customer;
use Database\Seeders\Ext\MainTestSeeder;
use Illuminate\Support\Facades\DB;

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
                    ->has(BoatDates::factory()->count(3),'dates')
                ->count(1),'boats'
            )
/*
            ->hasRoles(1, [
                'name' => 'boat',
                'guard_name' => 'web',
            ])
*/
            ->count($this->count)
            ->create()
        ;

        Role::getModel()->refresh();

//        if(DB::connection('demo')->table('roles')->where('name','=','boat')->first()) {
        if(Role::whereName('boat')->first()) {
            $customers->each(function (Customer $customer) {
                $customer->assignRole('boat');
            });
        }
    }
}
