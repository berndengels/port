<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\Caravan;
use App\Libs\Prices\CaravanPrice;
use Illuminate\Http\Request;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;

class CaravanPriceCalculationTest extends PriceCalculation
{
    protected $days = 2;
    /**
     * @var Caravan $caravan
     */
    protected $caravan;

    protected function setUp(): void
    {
        parent::setUp();
        $this->caravan = Caravan::factory()->create();
        $this->params = [
            'caravan_id'    => $this->caravan->id,
            'from'          => $this->from,
            'until'         => $this->until,
            'carlength'     => $this->caravan->carlength,
            'persons'       => 2,
            'electric'      => true,
            'day_price'     => 0
        ];
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_caravan_price_calculation()
    {
        $expected = $this->calculatedPrice($this->caravan);
        $response = $this
            ->asFakeUser()
            ->postJson(route('admin.caravanDates.price.calculate'), $this->params)
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


    protected function calculatedPrice(object $data): array
    {
        $request = new Request();
        $request->request->add($this->params);
        $price = (new CaravanPrice($this->from, $this->until))->getPrice($request);

        return $price;
    }
}
