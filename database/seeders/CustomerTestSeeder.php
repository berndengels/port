<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\Customer;
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
            ->connection('test')
            ->count($this->count)
            ->create();

        Role::getModel()->refresh();

        if(Role::whereName('boat')->first()) {
            dump('role boat exist!');
            $customers->each(function (Customer $customer) {
                $customer->assignRole('boat');
            });
        }
    }
}
