<?php
namespace Tests\Feature\PriceCalculation;

use App\Models\BoatGuest;
use Helmich\JsonAssert\JsonAssertions;

class GuestBoatPriceCalculationTest extends PriceCalculation
{
    use JsonAssertions;
    /**
     * @var BoatGuest $boat
     */
    protected $days = 2;
    protected $boat;

    protected function setUp(): void
    {
        parent::setUp();
        $this->boat = BoatGuest::factory()->create();
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
            ->postJson(route('admin.guestBoatDates.price.calculate'), $this->params)
            ->assertOk()
        ;
        $decoded = json_decode($response->getContent());
        dump(__FUNCTION__." => total: expected: $expected, actual: $decoded->total");

        $this->assertJsonValueEquals($response->getContent(),'total', $expected);
    }

    protected function calculatedPrice(object $boat): float|int
    {
        $pricePerMeter = config('port.prices.boat_guest.price_per_meter');
        $price = ($boat->length * $pricePerMeter * $this->days) * 10 / 10;
        return $price;
    }
}
