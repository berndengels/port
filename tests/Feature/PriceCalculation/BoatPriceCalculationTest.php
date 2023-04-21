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
    protected $modus = 'summer';
    protected $from = '2023-01-15';
    protected $until = '2023-01-17';

    protected function setUp(): void
    {
        parent::setUp();
        $this->boat     = Boat::first();
//        $this->from     = Carbon::create('2022-06-01');
//        $this->until    = Carbon::create('2022-09-30');
        $this->from     = null;
        $this->until    = null;
        $type   = $this->boat->type;
        $this->params = [
            'modus'         => $this->modus,
            'type'          => $type,
            'boat_id'       => $this->boat->id,
            'from'          => $this->from,
            'until'         => $this->until,
            'length'        => $this->boat->length,
            'width'         => $this->boat->width,
            'weight'        => $this->boat->weight,
            'crane'         => true,
            'transport'     => true,
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
        $msg = __FUNCTION__." => total: expected: $expected[total], actual: $decoded->total\n";
        $this->assertEquals($expected['total'], $decoded->total, $msg);
        echo $msg;
    }

    protected function calculatedPrice(object $data)
    {
        $request = new Request();
        $request->request->add($this->params);
        $price = (new BoatPrice($this->from, $this->until, $this->boat))->getPrice($request);
        return $price;
    }

}
