<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\Caravan;
use App\Libs\Prices\CaravanPrice;
use Carbon\Carbon;
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
    protected $from = '2023-01-15';
    protected $until = '2023-01-17';

    protected function setUp(): void
    {
        parent::setUp();
        $this->caravan = Caravan::first();
        $this->params = [
            'caravan_id'    => $this->caravan->id,
            'carnumber'     => $this->caravan->carnumber,
            'from'          => $this->from,
            'until'         => $this->until,
            'carlength'     => $this->caravan->carlength,
            'persons'       => 2,
            'electric'      => true,
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

        $msg = __FUNCTION__." => total: expected: $expected[total], actual: $decoded->total\n";
        $this->assertEquals($expected['total'], $decoded->total, $msg);
        echo $msg;

        $dailyPrices = collect($expected['dailyPrices']);
        $dailyPricesDays = $dailyPrices->keys();
        $countDailyPrices = $dailyPrices->count();
        $msg = __FUNCTION__." => dailyPrices count: expected: $this->days, actual: $countDailyPrices\n";
        $this->assertEquals($expected['days'], $this->days, $msg);
        echo $msg;

        $expectedDatePeriod = Period::make($this->from, $this->until);
        $dailyPricesDatePeriod = Period::make($dailyPricesDays->first(), Carbon::make($dailyPricesDays->last())->addDay());
        $msg = __FUNCTION__.' => dailyPrices DatePeriod: expected: '.$expectedDatePeriod->asString().', actual: '.$dailyPricesDatePeriod->asString()."\n";
        $this->assertEquals($expectedDatePeriod, $dailyPricesDatePeriod, $msg);
        echo $msg;

        $dailyPricesSum = $dailyPrices->pluck('price')->values()->sum();
        $msg = __FUNCTION__." => dailyPrices summe: expected: $dailyPricesSum, actual: $decoded->priceBase\n";
        $this->assertEquals($dailyPricesSum, $decoded->priceBase, $msg);
        echo $msg;
    }

    protected function calculatedPrice(object $data):array
    {
        $request  = new Request();
        $request->request->add($this->params);
        $price = (new CaravanPrice(Carbon::make($this->from), Carbon::make($this->until), $data))->getPrice($request);
        return $price;
    }
}
