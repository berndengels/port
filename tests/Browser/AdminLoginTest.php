<?php
namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AdminLoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function test_admin_login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                ->assertSee('Admin Login')
                ->loginAs($this->user(), 'admin', )
                ->assertAuthenticated('admin')
                ->visit('/admin')
                ->assertRouteIs('admin.dashboard')
            ;
        });
    }
}
