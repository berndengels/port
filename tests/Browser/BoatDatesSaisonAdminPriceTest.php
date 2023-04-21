<?php
namespace Tests\Browser;

use Carbon\Carbon;
use App\Models\BoatDates;
use Laravel\Dusk\Browser;
use Tests\Browser\Traits\UseScreenshotSlides;
use Tests\DuskTestCase;

class BoatDatesSaisonAdminPriceTest extends DuskTestCase
{
    protected $days;
    protected $model      = BoatDates::class;
    protected $dayPrice   = 12;
    protected $persons    = 5;
    protected $electric   = 2;
    protected $fromDate   = '2022-05-01';
    protected $untilDate  = '2022-10-31';
    protected $boatId     = 3;
    protected $modus      = 'summer';

    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function test_boat_dates_saison_price_calculation()
    {
        $this->screenName = __FUNCTION__;
        $this->screenDirectory = __FUNCTION__;

        $this->entity = ($this->model)::whereBoatId($this->boatId)->first();

        $this->browse(function (Browser $browser) {
            $from   = Carbon::create($this->fromDate);
            $until  = Carbon::create($this->untilDate);
            $this->days = $from->toPeriod($until)->toDatePeriod()->getDateInterval()->days;

            $this->actingAs($this->user());
            $browser
                ->visit('/admin/login')
                ->loginAs($this->user(), 'admin', )
                ->assertAuthenticated('admin')
                ->visit('/admin/boatDates/create')
                ->stepScreenshot($this->screenDirectory)
                ->assertRouteIs('admin.boatDates.create')
                ->assertInputPresent('boat_id')
                ->assertInputPresent('modus')
                ->assertInputPresent('from')
                ->assertInputPresent('until')
                ->assertInputPresent('crane')
                ->assertInputPresent('mast_crane')
                ->assertInputPresent('cleaning')
                ->assertInputPresent('default_price')
                ->assertInputPresent('price')
                ->assertInputPresent('prices')
                ->assertInputPresent('length')
                ->assertInputPresent('width')
                ->assertInputPresent('weight')
                ->assertInputPresent('mast_length')
                ->assertInputPresent('mast_weight')
                ->select('boat_id', $this->boatId)
                ->stepScreenshot($this->screenDirectory)
                ->select('modus', $this->modus)
                ->stepScreenshot($this->screenDirectory)
                ->typeDate('#from', $from)
                ->stepScreenshot($this->screenDirectory)
                ->typeDate('#until', $until)
                ->stepScreenshot($this->screenDirectory)
                ->check('crane', 1)
                ->stepScreenshot($this->screenDirectory)
                ->check('mast_crane', 1)
                ->stepScreenshot($this->screenDirectory)
                ->click('#default_price')
                ->wait(3)
//                ->assertInputValue('price', $this->calculateExpectedPrice())
                ->assertInputValueIsNot('price', '')
                ->assertInputValueIsNot('prices', '')
                ->assertInputValueIsNot('length', '')
                ->assertInputValueIsNot('width', '')
                ->assertInputValueIsNot('weight', '')
                ->stepScreenshot($this->screenDirectory)
            ;
            $this->createJpeg($this->screenName, false);
        });
    }

//    protected function calculateExpectedPrice(): int|float{}
}
