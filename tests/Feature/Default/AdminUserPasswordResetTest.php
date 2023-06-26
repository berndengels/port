<?php
namespace Tests\Feature\Default;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminResetPassword;

class AdminUserPasswordResetTest extends TestCase
{
    use WithFaker;

    const ROUTE_PASSWORD_REQUEST        = 'admin.password.request';
    const ROUTE_PASSWORD_RESET          = 'admin.password.reset';
    const ROUTE_PASSWORD_EMAIL          = 'admin.password.email';
    const ROUTE_PASSWORD_RESET_SUBMIT   = 'admin.password.update';
    const USER_ORIGINAL_PASSWORD        = 'password';
    const USER_GUARD                    = 'admin';

    public function testShowPasswordResetRequestPage()
    {
        $this
            ->get(route(self::ROUTE_PASSWORD_REQUEST))
//            ->get('admin/password/reset')
            ->assertSuccessful()
            ->assertSeeText('Passwort zurücksetzen')
            ->assertSeeText('Email')
            ->assertSeeText('Sende Passwort Reset-Link')
        ;
    }

    public function testSubmitPasswordResetRequestInvalidEmail()
    {
        $params = ['email' => Str::random()];
        $this
            ->from(route(self::ROUTE_PASSWORD_REQUEST))
            ->post(route(self::ROUTE_PASSWORD_EMAIL, $params), $params)
            ->assertSuccessful()
            ->assertSee(__('validation.email', [
                'attribute' => 'email',
            ]))
        ;
    }

    /**
     * Testing submitting the password reset request with an email
     * address not in the database.
     */
    public function testSubmitPasswordResetRequestEmailNotFound()
    {
        $params = ['email' => $this->faker->unique()->safeEmail];
        $response = $this
            ->from(route(self::ROUTE_PASSWORD_REQUEST))
            ->post(route(self::ROUTE_PASSWORD_EMAIL, $params), $params)
            ->assertSuccessful()
        ;
        $response->assertSeeText(__('passwords.user'));
    }

    /**
     * Testing submitting a password reset request.
     */
    public function testSubmitPasswordResetRequest()
    {
        $params = ['email' => $this->user->email];
        $this
            ->from(route(self::ROUTE_PASSWORD_REQUEST))
            ->post(route(self::ROUTE_PASSWORD_EMAIL), $params)
            ->assertSuccessful()
            ->assertSeeText(__('passwords.sent'))
        ;
        Notification::assertSentTo($this->user, AdminResetPassword::class);
    }

    public function testShowPasswordResetPage()
    {
        $token = Password::broker('admin_users')->createToken($this->user);
        $this
            ->get(route(self::ROUTE_PASSWORD_RESET, $token))
            ->assertSuccessful()
            ->assertSeeText('Passwort zurücksetzen')
            ->assertSeeText('Email')
            ->assertSeeText('Passwort')
            ->assertSeeText('Passwort wiederholen')
        ;
    }

    /**
     * Testing submitting the password reset page with an invalid
     * email address.
     */
    public function testSubmitPasswordResetInvalidEmail()
    {
        $token = Password::broker('admin_users')->createToken($this->user);
        $password = Str::random();
        $params = [
            'token' => $token,
            'email' => Str::random(),
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $this
            ->followingRedirects()
            ->from(route(self::ROUTE_PASSWORD_RESET, [
                'token' => $token,
            ]))
            ->post(route(self::ROUTE_PASSWORD_RESET_SUBMIT, $params), $params)
            ->assertSuccessful()
            ->assertSee(__('validation.email', [
                'attribute' => 'email',
            ]));

        $this->user->refresh();
        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check(env('ADMIN_PW'), $this->user->password));
    }

    /**
     * Testing submitting the password reset page with an email
     * address not in the database.
     */
    public function testSubmitPasswordResetEmailNotFound()
    {
        $token = Password::broker('admin_users')->createToken($this->user);
        $password = Str::random();
        $params = [
            'token' => $token,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $this
            ->followingRedirects()
            ->from(route(self::ROUTE_PASSWORD_RESET, [
                'token' => $token,
            ]))
            ->post(route(self::ROUTE_PASSWORD_RESET_SUBMIT, $params), $params)
            ->assertSuccessful()
            ->assertSee(__('passwords.user'));

        $this->user->refresh();
        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('password', $this->user->password));
    }

    /**
     * Testing submitting the password reset page with a password
     * that doesn't match the password confirmation.
     */
    public function testSubmitPasswordResetPasswordMismatch()
    {
        $token = Password::broker('admin_users')->createToken($this->user);
        $password = Str::random();
        $password_confirmation = Str::random();
        $params = [
            'token' => $token,
            'email' => $this->user->email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
        ];
        $this
            ->followingRedirects()
            ->from(route(self::ROUTE_PASSWORD_RESET, [
                'token' => $token,
            ]))
            ->post(route(self::ROUTE_PASSWORD_RESET_SUBMIT, $params), $params)
            ->assertSuccessful()
            ->assertSee(__('validation.confirmed', [
                'attribute' => 'password',
            ]));

        $this->user->refresh();
        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('password', $this->user->password));
    }

    /**
     * Testing submitting the password reset page with a password
     * that is not long enough.
     */
    public function testSubmitPasswordResetPasswordTooShort()
    {
        $token = Password::broker('admin_users')->createToken($this->user);
        $password = Str::random(5);
        $params = [
            'token' => $token,
            'email' => $this->user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $this
            ->followingRedirects()
            ->from(route(self::ROUTE_PASSWORD_RESET, [
                'token' => $token,
            ]))
            ->post(route(self::ROUTE_PASSWORD_RESET_SUBMIT, $params), $params)
            ->assertSuccessful()
            ->assertSeeText(__('validation.min.string', [
                'attribute' => 'password',
                'min' => 8,
            ]));

        $this->user->refresh();
        $this->assertFalse(Hash::check($password, $this->user->password));
        $this->assertTrue(Hash::check('password', $this->user->password));
    }

    /**
     * Testing submitting the password reset page.
     */
    public function testSubmitPasswordReset()
    {
        $token = Password::broker('admin_users')->createToken($this->user);
        $password = Str::random();
        $params = [
            'token' => $token,
            'email' => $this->user->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $this
            ->from(route(self::ROUTE_PASSWORD_RESET, ['token' => $token]))
            ->post(route(self::ROUTE_PASSWORD_RESET_SUBMIT, $params), $params)
            ->assertSuccessful()
        ;

        $this->user->refresh();
        $this->assertAuthenticatedAs($this->user);
        $this->assertFalse(Hash::check('password', $this->user->password));
        $this->assertTrue(Hash::check($password, $this->user->password));
    }
}
