<?php
namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\Password;

class AdminResetPasswordTest extends DuskTestCase
{
    const ROUTE_PASSWORD_REQUEST        = 'admin.password.request';
    const ROUTE_PASSWORD_RESET          = 'admin.password.reset';
    const ROUTE_PASSWORD_EMAIL          = 'admin.password.email';
    const ROUTE_PASSWORD_RESET_SUBMIT   = 'admin.password.update';
    const USER_ORIGINAL_PASSWORD        = 'password';
    const USER_GUARD                    = 'admin';
    const AUTH_PASSWORD_BROKER          = 'admin_users';

    protected $screenDirectory;
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function test_admin_password_reset()
    {
        $this->screenDirectory = __FUNCTION__;

        $this->browse(function (Browser $browser) {
            $password = 'password2';
            $browser->logout(self::USER_GUARD);
            $browser
                ->visitRoute(self::ROUTE_PASSWORD_REQUEST)
                ->assertSee('Passwort zurücksetzen')
                ->assertInputPresent('email')
                ->stepScreenshot($this->screenDirectory)
                ->type('input[name="email"]', $this->user->email)
                ->stepScreenshot($this->screenDirectory)
                ->click('button[name="submit"]')
                ->wait(1)
                ->assertSee(__('passwords.sent'))
                ->stepScreenshot($this->screenDirectory)
            ;
            $token = Password::broker(self::AUTH_PASSWORD_BROKER)
                ->createToken($this->user)
            ;
            $paramToken = ['token' => $token];
            $browser
                ->visit(route(self::ROUTE_PASSWORD_RESET, $paramToken))
                ->stepScreenshot($this->screenDirectory)
                ->assertSee('Passwort zurücksetzen')
                ->assertInputPresent('email')
                ->assertInputPresent('password')
                ->assertInputPresent('password_confirmation')
                ->type('input[name="email"]', $this->user->email)
                ->type('input[name="password"]', $password)
                ->type('input[name="password_confirmation"]', $password)
                ->stepScreenshot($this->screenDirectory)
                ->click('button[name="submit"]')
                ->wait(1)
                ->stepScreenshot($this->screenDirectory)
                ->assertRouteIs('admin.dashboard')
                ->assertAuthenticatedAs($this->user, self::USER_GUARD)
            ;
        });
    }
}
