<?php
namespace Tests\Feature\PriceCalculation;

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
    }

    abstract protected function calculatedPrice(object $data);
}
