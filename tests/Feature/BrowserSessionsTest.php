<?php
namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrowserSessionsTest extends TestCase
{
//    use RefreshDatabase;

    public function test_other_browser_sessions_can_be_logged_out()
    {
        $this->actingAs($user = AdminUser::whereEmail('test@test.com')->first());

        $response = $this->delete('/user/other-browser-sessions', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors();
    }
}
