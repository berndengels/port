<?php
namespace Tests\Browser;

use Carbon\Carbon;
use App\Models\GuestBoat;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GuestBoatAdminPriceTest extends DuskTestCase
{
    protected $days = 3;
    protected $persons = 3;
    protected $electric = true;
    protected $model = GuestBoat::class;
    protected $entity;
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
                ->visit('/admin/guestBoatDates/create')
                ->wait(3)
                ->assertRouteIs('admin.guestBoatDates.create')
                ->assertInputPresent('name')
                ->assertInputPresent('home_port')
                ->assertInputPresent('length')
                ->assertInputPresent('from')
                ->assertInputPresent('until')
                ->assertInputPresent('electric')
                ->assertInputPresent('persons')
                ->assertInputPresent('price')
                ->typeSlowly('name', 'E')
                ->waitFor('ul.autocomplete')
                ->click('ul.autocomplete>li:first-child')
                ->with('form', function (Browser $form) {
                    $name   = $form->inputValue('name');
                    $length = $form->inputValue('length');
                    $this->entity = GuestBoat::whereName($name)
                        ->whereLength($length)
                        ->first()
                    ;
                    echo "entity name: ".$this->entity->name."\n";
                    echo "found name: $name\n";
                })
                ->stepScreenshot($this->screenDirectory)
                ->typeDate('#from', $from)
                ->typeDate('#until', $until)
                ->type('persons', $this->persons);

            if($this->electric) {
                $browser->check('electric');
            }

            $browser->check('electric')
                ->click('#home_port')
                ->wait(3)
                ->stepScreenshot($this->screenDirectory)
                ->with('form', function (Browser $form) {
                    $price = $form->inputValue('price');
//                    echo "price: $price\n";
                })
                ->assertInputValue('price', $this->calculateExpectedPrice())
                ->assertInputValueIsNot('prices', '')
                ->stepScreenshot($this->screenDirectory)
            ;
        });
    }

    protected function calculateExpectedPrice(): int|float
    {
        $dayPricePerMeter = 1.5;
        $electricPricePerDay = $this->electric ? 2 : 0;
        $personsInclusice = 2;
        $personsPrice = $this->persons - $personsInclusice;
        $personsPrice = ($personsPrice > 0) ? $personsPrice : 0;
        $price = (float) (($this->entity['length'] * $dayPricePerMeter + $electricPricePerDay + $personsPrice) * $this->days);

        return ceil($price);
    }
}
