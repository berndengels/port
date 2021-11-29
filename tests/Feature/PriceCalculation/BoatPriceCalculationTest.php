<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\Boat;
use App\Libs\Prices\BoatPrice;
use Illuminate\Http\Request;

class BoatPriceCalculationTest extends PriceCalculation
{
    /**
     * @var Boat $boat
     */
    protected $boat;
    protected $modus = 'saison';

    protected function setUp(): void
    {
        parent::setUp();
        $this->boat     = $this->customer->boats->first();
//        $this->from     = Carbon::create('2022-05-01');
//        $this->until    = Carbon::create('2022-10-31');
        $this->from     = null;
        $this->until    = null;

        $type   = $this->boat->boat_type;
        $this->params = [
            'modus'         => $this->modus,
            'boat_type'     => $type,
            'boat_id'       => $this->boat->id,
            'from'          => $this->from,
            'until'         => $this->until,
            'length'        => $this->boat->length,
            'width'         => $this->boat->width,
            'weight'        => $this->boat->weight,
            'crane'         => true,
            'cleaning'      => 'winter' === $this->modus ? true : false,
            'mast_crane'    => ('sail' === $type) ? true : false,
            'mast_length'   => ('sail' === $type) ? $this->boat->mast_length : 0,
            'mast_weight'   => ('sail' === $type) ? $this->boat->mast_weight : 0,
        ];
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_boat_price_calculation()
    {
        $expected = $this->calculatedPrice($this->boat);
        $response = $this
            ->asFakeUser()
            ->postJson(route('admin.boatDates.price.calculate'), $this->params)
            ->assertOk()
        ;
        $decoded = json_decode($response->getContent());
        $msg = __FUNCTION__." => total: expected: $expected, actual: $decoded->total";
        $this->assertEquals($expected, $decoded->total, $msg);
    }

    protected function calculatedPrice(object $data): float|int
    {
        $request = new Request();
        $request->request->add($this->params);
        $price = (new BoatPrice($this->from, $this->until, $this->boat))->getPrice($request);

        return $price['total'];
    }

}
