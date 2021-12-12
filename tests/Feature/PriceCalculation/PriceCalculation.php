<?php
namespace Tests\Feature\PriceCalculation;

use Carbon\Carbon;
use Tests\TestCase;
use Helmich\JsonAssert\JsonAssertions;

abstract class PriceCalculation extends TestCase
{
    use JsonAssertions;
    protected $days = 2;
    protected $from;
    protected $until;
    protected $params;

    protected function setUp(): void
    {
        parent::setUp();
        $today          = Carbon::today();
        $this->from     = $today;
        $this->until    = $today->copy()->addDays($this->days);
    }

    abstract protected function calculatedPrice(object $data): array;

}
