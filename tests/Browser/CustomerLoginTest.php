<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CustomerLoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function test_customer_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Kunden Login')
                ->loginAs($this->customer(), 'customer', )
                ->assertAuthenticated('customer')
                ->visit('/dashboard')
                ->assertRouteIs('public.dashboard')
            ;
        });
    }
}
