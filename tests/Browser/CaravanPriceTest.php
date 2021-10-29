<?php
namespace Tests\Browser;

use Carbon\Carbon;
use Tests\DuskTestCase;
use App\Models\Caravan;
use Laravel\Dusk\Browser;

class CaravanPriceTest extends DuskTestCase
{
    private $price = 0;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_caravan_price_calculation()
    {
        $this->screenName   = __FUNCTION__;

        $this->browse(function (Browser $browser) {
            $days       = 3;
            $dayPrice   = 12;
            $personsInclusive = config('port.prices.caravan.persons_inclusivce');
            $persons    = 5;
            $personsPrice = ($persons < $personsInclusive) ? 0 : $persons - $personsInclusive;
            if($personsPrice < 0) {
                $personsPrice = 0;
            }
            $electric   = 2;
            $expectedPrice = (int) (($dayPrice + $electric + $personsPrice) * $days);
            $today = Carbon::today();
            $from   = $today;
            $until  = $today->copy()->addDays($days);

            $browser
                ->visit('/admin/login')
                ->loginAs($this->adminUser, 'admin', )
                ->visit('/admin/caravanDates/create')
                ->assertAuthenticated('admin')
                ->assertRouteIs('admin.caravanDates.create')
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
                ->typeSlowly('carnumber', 'B')
                ->waitFor('ul.autocomplete')
                ->click('ul.autocomplete>li:first-child')
                ->with('form', function (Browser $form) {
                    $carnumber = $form->inputValue('carnumber');
                    $this->caravan = Caravan::whereCarnumber($carnumber)->first();
                })
                ->typeDate('#from', $from)
                ->typeDate('#until', $until)
                ->check('electric', !!$electric)
                ->type('persons', $persons)
                ->type('#email','')
                ->waitFor('#price', 2)
                ->assertInputValue('price', $expectedPrice)
                ->assertInputValueIsNot('prices', '')
                ->screenshot($this->screenName)
                ->logout('admin')
            ;
            static::createJpeg($this->screenName);
        });
    }
}
