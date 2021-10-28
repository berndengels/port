<?php
namespace Tests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
