<?php
namespace Tests\Browser;

use Carbon\Carbon;
use Tests\DuskTestCase;
use App\Models\Caravan;
use Laravel\Dusk\Browser;

class CaravanPriceTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_caravan_price_calculation()
    {
        $today = Carbon::today();
        $this->from         = $today;
        $this->until        = $today->copy()->addDays(3);
        $this->screenName   = __FUNCTION__;

        $this->browse(function (Browser $browser) {
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
                ->typeDate('#from', $this->from)
                ->typeDate('#until', $this->until)
                ->check('electric', 1)
                ->type('persons', 3)
                ->type('#email','')
                ->waitFor('#price', 2)
                ->assertInputValueIsNot('price', '')
                ->assertInputValueIsNot('prices', '')
                ->screenshot($this->screenName)
                ->logout('admin')
            ;
            static::createJpeg($this->screenName);
        });
    }
}
