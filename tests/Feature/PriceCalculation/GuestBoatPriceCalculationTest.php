<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\GuestBoat;
use Helmich\JsonAssert\JsonAssertions;

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
            'day_price'     => 0
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
        $msg = __FUNCTION__." => total: expected: $expected, actual: $decoded->total";
        $this->assertEquals($expected, $decoded->total, $msg);
    }

    protected function calculatedPrice(object $boat): float|int
    {
        $pricePerMeter = config('port.prices.boat_guest.price_per_meter');
        $electric = $this->params['electric'] ? 2 : 0;
        $persons = $this->params['persons'] > 3 ? 1: 0;
        $price = (($boat->length * $pricePerMeter + $electric + $persons) * $this->days) * 10 / 10;
        return $price;
    }
}
