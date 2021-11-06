<?php
namespace Tests\Feature;

use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAuthenticationTest extends TestCase
{
//    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $this->post('/login', [
                'email' => $this->customer->email,
                'password' => 'password',
            ])
            ->assertOk()
//            ->assertLocation(RouteServiceProvider::HOME)
        ;
        $this->assertAuthenticated('customer');
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $this->post('/login', [
            'email' => $this->customer->email,
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }
}
