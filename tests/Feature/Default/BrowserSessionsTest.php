<?php
namespace Tests\Feature\Default;

use Tests\TestCase;

class BrowserSessionsTest extends TestCase
{
//    use RefreshDatabase;

    public function test_other_browser_sessions_can_be_logged_out()
    {
        $this->actingAs($user = $this->user);

        $response = $this->delete('/user/other-browser-sessions', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();
    }
}
