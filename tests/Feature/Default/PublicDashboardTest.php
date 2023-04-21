<?php
namespace Tests\Feature\Default;

use Tests\TestCase;

class PublicDashboardTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_redirect_public()
    {
        $this->get('/')
            ->assertStatus(200)
        ;
    }

    public function test_dashboard_public()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }
}
