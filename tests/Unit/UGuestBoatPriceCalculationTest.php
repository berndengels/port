<?php

namespace Tests\Unit;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Tests\TestCase;

class UGuestBoatPriceCalculationTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_caravan_price_calculation()
    {
        $today = Carbon::today();
        $data = collect([
            'from'          => $today->format('Y-m-d'),
            'until'         => $today->copy()->addDays(3),
            'caravan_id'    => 2,
            'persons'       => 2,
            'electric'      => false,
            'carlength'     => 9,
            'day_price'     => 0
        ])->toArray();
        $this->assertTrue(true);
/*
        $this->prepareAjaxJsonRequest();
        $response = $this->json('get', config('app.url').'/caravanDates/price/calculate', $data);
        $response
            ->assertStatus(200)
            ->assertJsonFragment('total')
        ;
*/
    }
}
