<?php
namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

abstract class AdminPriceTest extends DuskTestCase
{
    protected $days = 3;
    protected $model;
    protected $entity;

    protected function setUp(): void
    {
        parent::setUp();
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/admin/login')
                ->loginAs($this->user(), 'admin', )
                ->assertAuthenticated('admin');
        });
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        $this->browse(function (Browser $browser) {
            $browser->logout('admin');
        });
    }

    protected function config($name) {
        return app('config')->get($name);
    }

    protected abstract function calculateExpectedPrice(): int|float;
}
