<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_redirect_public()
    {
        $response = $this->get('/');
        $response->assertRedirect('/dashboard');
        $response->assertStatus(302);
    }

    public function test_dashboard_public()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }
}
