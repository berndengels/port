<?php
namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BoatTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function test_boat_list()
    {
        $this->screenName   = __FUNCTION__;
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user(), 'admin', )
                ->assertAuthenticated('admin')
                ->visit(route('admin.guestBoats.index'))
                ->assertSee('Bootsname')
                ->screenshot($this->screenName);
            $this->createJpeg($this->screenName);
        });
    }
}
