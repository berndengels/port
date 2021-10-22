<?php
namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Role;
use Database\Seeders\Ext\MainSeeder;

class CustomerSeeder extends MainSeeder
{
    protected $table = 'customers';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::getModel()->refresh();
        /**
         * @var $customer Customer
         */
        $customer = Customer::factory()->create();
//        $customer->assignRole('boat');
    }
}
