<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\Caravan;
use App\Libs\Prices\CaravanPrice;
use Illuminate\Http\Request;

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
        dump(__FUNCTION__." => total: expected: $expected, actual: $decoded->total");

        $this->assertJsonValueEquals($response->getContent(),'total', $expected);
    }

    protected function calculatedPrice(object $data): float|int
    {
        $request = new Request();
        $request->request->add($this->params);
        $price = (new CaravanPrice($this->from, $this->until))->getPrice($request);

        return $price['total'];
    }
}
