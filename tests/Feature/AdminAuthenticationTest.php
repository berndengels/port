<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\AdminUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAuthenticationTest extends TestCase
{
//    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = AdminUser::whereEmail('test@test.com')->first();
        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated('admin');
        $response->assertRedirect(RouteServiceProvider::ADMIN_HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = AdminUser::whereEmail('test@test.com')->first();
        $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }
}
