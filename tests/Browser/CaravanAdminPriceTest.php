<?php
namespace Tests\Browser;

use Carbon\Carbon;
use App\Models\Caravan;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CaravanAdminPriceTest extends DuskTestCase
{
    protected $days       = 3;
    protected $model      = Caravan::class;
    protected $dayPrice   = 12;
    protected $persons    = 5;
    protected $electric   = 2;
    public static $counter = 0;
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function test_caravan_price_calculation()
    {
        $this->screenName = __FUNCTION__.'/';
        $this->browse(function (Browser $browser) {
            $today  = Carbon::today();
            $from   = $today;
            $until  = $today->copy()->addDays($this->days);
            $this->actingAs($this->user());
            $browser
                ->visit('/admin/login')
                ->loginAs($this->user(), 'admin', )
                ->assertAuthenticated('admin')
                ->visit('/admin/caravanDates/create')
                ->screenshot($this->screenName.static::$counter)
                ->with('form', function (Browser $form) {
                    static::$counter++;
                })
                ->assertRouteIs('admin.caravanDates.create')
                ->assertInputPresent('carnumber')
                ->assertInputPresent('country_id')
                ->assertInputPresent('carlength')
                ->assertInputPresent('email')
                ->assertInputPresent('from')
                ->assertInputPresent('until')
                ->assertInputPresent('electric')
                ->assertInputPresent('persons')
                ->assertInputPresent('price')
                ->typeSlowly('carnumber', 'B')
                ->waitFor('ul.autocomplete')
                ->screenshot($this->screenName.static::$counter)
                ->with('form', function (Browser $form) {
                    static::$counter++;
                })
                ->click('ul.autocomplete>li:first-child')
                ->with('form', function (Browser $form) {
                    $carnumber = $form->inputValue('carnumber');
                    $this->entity = ($this->model)
//                        ::on($this->dbConnectionName)
                        ::whereCarnumber($carnumber)
                        ->first()
                    ;
                })
                ->typeDate('#from', $from)
                ->screenshot($this->screenName.static::$counter)
                ->with('form', function (Browser $form) {
                    static::$counter++;
                })
                ->typeDate('#until', $until)
                ->screenshot($this->screenName.static::$counter)
                ->with('form', function (Browser $form) {
                    static::$counter++;
                })
                ->check('electric', !!$this->electric)
                ->screenshot($this->screenName.static::$counter)
                ->with('form', function (Browser $form) {
                    static::$counter++;
                })
                ->type('persons', $this->persons)
                ->screenshot($this->screenName.static::$counter)
                ->with('form', function (Browser $form) {
                    static::$counter++;
                })
                ->click('#email')
                ->screenshot($this->screenName.static::$counter)
                ->with('form', function (Browser $form) {
                    static::$counter++;
                })
                ->wait(3)
                ->assertInputValue('price', $this->calculateExpectedPrice())
                ->assertInputValueIsNot('prices', '')
                ->screenshot($this->screenName.static::$counter)
                ->with('form', function (Browser $form) {
                    static::$counter++;
                })
            ;
//            $this->createJpeg($this->screenName);
        });
    }

    protected function calculateExpectedPrice(): int|float
    {
//        $personsInclusive = $this->config('port.prices.caravan.persons_inclusivce');
        $personsInclusive = 2;
        $personsPrice = ($this->persons < $personsInclusive) ? 0 : $this->persons - $personsInclusive;
        if($personsPrice < 0) {
            $personsPrice = 0;
        }
        $price = ($this->dayPrice + $this->electric + $personsPrice) * $this->days;
        return $price;
    }
}
