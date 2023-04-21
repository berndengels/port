<?php
namespace Tests\Feature\Default;

use Tests\TestCase;

class CustomerAuthenticationTest extends TestCase
{
//    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testCustumerLoginViaFakeCustomer()
    {
        $this
            ->asFakeCustomer()
            ->assertAuthenticated('customer')
        ;
    }

    public function testCostumerNotConfirmedLoginFail()
    {
        $params = [
            'email' => $this->customer->email,
            'password' => 'password',
        ];
        $response = $this
            ->followingRedirects()
            ->from(route('public.dashboard'))
            ->post(route('customer.login', $params), $params);
        $response
            ->assertOk()
            ->assertSeeText('Sorry, Ihre Kunden-Registrierung wurde noch nicht bestätigt')
        ;
        $this->assertGuest();
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
