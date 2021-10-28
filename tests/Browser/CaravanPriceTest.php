<?php

namespace Tests\Browser;

use App\Models\AdminUser;
use App\Models\Caravan;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CaravanPriceTest extends DuskTestCase
{
    private $caravan;

    public function __construct()
    {
//        $this->caravanDates = $this->caravan->dates->first();
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_caravan_price_calculation()
    {
//        $this->adminUser = AdminUser::whereEmail('test@test.com')->first();
        $this->adminUser = ['email' => 'test@test.com', 'password' => 'password'];
//        $this->caravan = Caravan::find(1);

        $this->browse(function (Browser $browser) {

            $browser
//                ->loginAs($this->adminUser, 'admin')
                ->visit('/caravanDates/create')
                ->assertAuthenticated('admin')
/*
                ->assertInputPresent('carnumber')
                ->assertInputPresent('country_id')
                ->assertInputPresent('carlength')
                ->assertInputPresent('email')
                ->assertInputPresent('from')
                ->assertInputPresent('until')
                ->assertInputPresent('electric')
                ->assertInputPresent('persons')
                ->assertInputPresent('day_price')
                ->assertInputPresent('price')
                ->assertInputPresent('priccce')
*/
                ->logout('admin')
            ;
        });
    }
}
