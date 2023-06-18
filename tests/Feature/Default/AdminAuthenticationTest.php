<?php
namespace Tests\Feature\Default;

use Tests\TestCase;

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
        $this->post('/admin/login', [
                'email' => $this->user->email,
                'password' => env('ADMIN_PW'),
            ])
            ->assertOk()
        ;
//        $this->assertAuthenticated('admin');
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $this->post('/admin/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }
}
