<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\GuestBoat;
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->boat = GuestBoat::factory()->create();
        $this->params = [
            'boat_guest_id' => $this->boat->id,
            'from'          => $this->from->format('Y-m-d'),
            'until'         => $this->from->copy()->addDays($this->days)->format('Y-m-d'),
            'length'        => $this->boat->length,
            'electric'      => true,
            'persons'       => 2,
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
            ->postJson(route('admin.guestBoatDates.price.calculate', $this->params), $this->params)
            ->assertOk()
        ;
        $decoded = json_decode($response->getContent());
        $msg = __FUNCTION__." => total: expected: $expected[total], actual: $decoded->total";
        $this->assertEquals($expected['total'], $decoded->total, $msg);

        $dailyPrices = collect($expected['dailyPrices']);
        $dailyPricesDays = $dailyPrices->keys();
        $countDailyPrices = $dailyPrices->count();

        $msg = __FUNCTION__." => dailyPrices count: expected: $this->days, actual: $countDailyPrices";
        $this->assertEquals($countDailyPrices, $this->days, $msg);

        $expectedDatePeriod = Period::make($this->from, $this->until);
        $dailyPricesDatePeriod = Period::make($dailyPricesDays->first(), $dailyPricesDays->last());
        $msg = __FUNCTION__.' => dailyPrices DatePeriod: expected: '.$expectedDatePeriod->asString().', actual: '.$dailyPricesDatePeriod->asString();
        $this->assertEquals($countDailyPrices, $this->days, $msg);

        $dailyPricesSum = $dailyPrices->values()->sum();
        $msg = __FUNCTION__." => dailyPrices summe: expected: $dailyPricesSum, actual: $decoded->priceBase";
        $this->assertEquals($dailyPricesSum, $decoded->priceBase, $msg);
    }

    protected function calculatedPrice(object $boat): array
    {
        $request = new Request();
        $request->request->add($this->params);
        $price = (new GuestBoatPrice($this->from, $this->until, $this->boat))->getPrice($request);

        return $price;
    }
}
