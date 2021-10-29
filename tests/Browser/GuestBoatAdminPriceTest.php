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
     *
     * @return void
     */
    public function test_guest_boat_price_calculation()
    {
        $this->screenName   = __FUNCTION__;

        $this->browse(function (Browser $browser) {
            $days   = 3;
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
                ->typeSlowly('name', 'A')
                ->waitFor('ul.autocomplete')
                ->click('ul.autocomplete>li:first-child')
                ->with('form', function (Browser $form) {
                    $this->entity = ($this->model)::whereName($form->inputValue('name'))
                        ->first();
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
            static::createJpeg($this->screenName);
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
