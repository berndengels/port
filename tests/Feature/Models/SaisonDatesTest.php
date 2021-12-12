<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\ConfigSaisonDates;

class SaisonDatesTest extends TestCase
{
    public function testFromMdayStoredAndValide()
    {
        $saisonDate = ConfigSaisonDates::factory()->create();
        $expected = $saisonDate->from_month . $saisonDate->from_day;
        $this->assertDatabaseHas($saisonDate, ['from_mday' => $expected]);
    }

    public function testUntilMdayStoreddAndValide()
    {
        $saisonDate = ConfigSaisonDates::factory()->create();
        $expected = $saisonDate->until_month . $saisonDate->until_day;
        $this->assertDatabaseHas($saisonDate, ['until_mday' => $expected]);
    }
}
