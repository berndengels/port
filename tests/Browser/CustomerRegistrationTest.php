<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class CustomerRegistrationTest extends DuskTestCase
{
    const ROUTE_RREGISTER_REQUEST   = 'register';
    const ROUTE_RREGISTER_SUBMIT    = 'register';
    const ROUTE_RREGISTER_HOME      = 'public.dashboard';
    const USER_GUARD                = 'customer';

    private $params = [
        'name'      => 'Paul Meier',
        'email'     => 'paul@meier.de',
        'password'  => 'password',
        'password_confirmation' => 'password',
        'fon'       => '12345678',
        'street'    => 'Hauptstrasse 11',
        'postcode'  => '12998',
        'city'      => 'Hummelsbach',
        'name' => 'Ohne Yoko',
        'length'    => 10,
        'width'     => 3.5,
        'weight'    => 4000,
        'draft'     => 1.6,
        'length_waterline' => 9,
        'mast_weight'      => 100,
        'mast_length'      => 11,
        'length_keel'      => 2,
        'board_height'     => 1.3,
    ];
    private $selectParams = [
        'type' => 'sail',
    ];

    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function test_customer_registration()
    {
        $this->screenDirectory = __FUNCTION__;
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(route(self::ROUTE_RREGISTER_REQUEST))
                ->assertGuest()
                ->assertSee('Registrierung für Kunden')
                ->stepScreenshot($this->screenDirectory)
            ;
            foreach ($this->selectParams as $name => $value) {
                $browser
                    ->select('select[name="'.$name.'"]', $value)
                ;
            }
            $browser->waitFor('input[name="mast_weight"]');
            foreach ($this->params as $name => $value) {
                $browser->type('input[name="'.$name.'"]', $value);
            }

            $browser->stepScreenshot($this->screenDirectory);
            $browser->click('button[type="submit"]')
                ->waitForRoute(self::ROUTE_RREGISTER_HOME)
                ->assertAuthenticated('customer')
                ->assertSee('Logout')
                ->stepScreenshot($this->screenDirectory)
            ;
        });
    }
}
