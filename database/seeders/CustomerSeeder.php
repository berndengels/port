<?php
namespace Database\Seeders;

use App\Models\Customer;
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
        Customer::factory()->count($this->count)->create();
    }
}
