<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\GuestBoat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Libs\Prices\GuestBoatPrice;
use Helmich\JsonAssert\JsonAssertions;
use Spatie\Period\Period;

class GuestBoatPriceCalculationTest extends PriceCalculation
{
    use JsonAssertions;
    /**
     * @var GuestBoat $boat
     */
    protected $days = 2;
    protected $boat;
    protected $from = '2023-06-15';
    protected $until = '2023-06-17';

    protected function setUp(): void
    {
        parent::setUp();

        $this->boat = GuestBoat::first();
        $this->params = [
            'boat_guest_id' => $this->boat->id,
            'from'          => $this->from,
            'until'         => $this->until,
            'length'        => $this->boat->length,
            'electric'      => true,
            'persons'       => 2,
            'transport'     => false,
        ];
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_guest_boat_price_calculation()
    {
        $expected = $this->calculatedPrice($this->boat);
        $response = $this
            ->asFakeUser()
            ->postJson(route('admin.guestBoatDates.price.calculate'), $this->params)
            ->assertOk()
        ;
        $decoded = json_decode($response->getContent());
        $msg = __FUNCTION__." => total: expected: $expected[total], actual: $decoded->total\n";
        $this->assertEquals($expected['total'], $decoded->total, $msg);
        echo $msg;

        $dailyPrices = collect($expected['dailyPrices']);
        $dailyPricesDays = $dailyPrices->keys();
        $countDailyPrices = $dailyPrices->count();

        $msg = __FUNCTION__." => dailyPrices count: expected: $this->days, actual: $countDailyPrices\n";
        $this->assertEquals($countDailyPrices, $this->days, $msg);
        echo $msg;

        $expectedDatePeriod = Period::make($this->from, $this->until);
        $dailyPricesDatePeriod = Period::make($dailyPricesDays->first(), $dailyPricesDays->last());
        $msg = __FUNCTION__.' => dailyPrices DatePeriod: expected: '.$expectedDatePeriod->asString().', actual: '.$dailyPricesDatePeriod->asString() . "\n";
        $this->assertEquals($countDailyPrices, $this->days, $msg);
        echo $msg;

        $dailyPricesSum = $dailyPrices->pluck('price')->values()->sum();
        $msg = __FUNCTION__." => dailyPrices summe: expected: $dailyPricesSum, actual: $decoded->priceBase\n";
        $this->assertEquals($dailyPricesSum, $decoded->priceBase, $msg);
        echo $msg;
    }

    protected function calculatedPrice(object $boat): array
    {
        $request = new Request();
        $request->request->add($this->params);
        $price = (new GuestBoatPrice(Carbon::make($this->from), Carbon::make($this->until), $boat))->getPrice($request);
        return $price;
    }
}
