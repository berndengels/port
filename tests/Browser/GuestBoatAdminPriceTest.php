<?php
namespace Tests\Browser;

use Carbon\Carbon;
use App\Models\BoatGuest;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GuestBoatAdminPriceTest extends DuskTestCase
{
    protected $days = 3;
    protected $model = BoatGuest::class;

    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function test_guest_boat_price_calculation()
    {
        $this->screenDirectory = __FUNCTION__;
        $this->browse(function (Browser $browser) {
            $today  = Carbon::today();
            $from   = $today;
            $until  = $today->copy()->addDays($this->days);

            $browser
                ->visit('/admin/login')
                ->loginAs($this->user(), 'admin', )
                ->assertAuthenticated('admin')
                ->visit('/admin/boatGuestDates/create')
                ->assertRouteIs('admin.boatGuestDates.create')
                ->assertInputPresent('name')
                ->assertInputPresent('home_port')
                ->assertInputPresent('length')
                ->assertInputPresent('from')
                ->assertInputPresent('until')
                ->assertInputPresent('price')
                ->typeSlowly('name', 'E')
                ->waitFor('ul.autocomplete')
                ->stepScreenshot($this->screenDirectory)
            ;
//            $this->createJpeg($this->screenName);
/*
                ->click('ul.autocomplete>li:first-child')
                ->with('form', function (Browser $form) {
                    $name = $form->inputValue('name');
                    $this->entity = $this->model
//                        ::on($this->dbConnectionName)
                        ::whereName($name)
                        ->first();
                    dump($name);
                })
                ->typeDate('#from', $from)
                ->typeDate('#until', $until)
                ->click('#home_port')
                ->wait(3)
                ->with('form', function (Browser $form) {
                    $price = $form->inputValue('price');
                    echo "price: $price\n";
                })
                ->assertInputValue('price', $this->calculateExpectedPrice())
                ->assertInputValueIsNot('prices', '')
                ->screenshot($this->screenName)
            ;
*/
        });
    }

    protected function calculateExpectedPrice(): int|float
    {
//        $dayPricePerMeter = $this->config('port.prices.boat_guest.price_per_meter');
        $dayPricePerMeter = 1.5;
        $price = (float) ($this->entity->length * $dayPricePerMeter * $this->days);
        return $price;
    }
}
