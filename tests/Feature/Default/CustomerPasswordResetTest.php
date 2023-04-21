<?php
namespace Tests\Feature\Default;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

class CustomerPasswordResetTest extends TestCase
{
    use WithFaker;

    const ROUTE_PASSWORD_EMAIL          = 'customer.password.email';
    const ROUTE_PASSWORD_REQUEST        = 'customer.password.request';
    const ROUTE_PASSWORD_RESET          = 'customer.password.reset';
    const ROUTE_PASSWORD_RESET_SUBMIT   = 'customer.password.update';
    const USER_ORIGINAL_PASSWORD        = 'password';
    const USER_GUARD                    = 'customer';

    public function testShowPasswordResetRequestPage()
    {
        $this
            ->get(route(self::ROUTE_PASSWORD_REQUEST))
            ->assertSuccessful()
            ->assertSeeText('Passwort zurücksetzen')
            ->assertSeeText('Email')
            ->assertSeeText('Sende Passwort Reset-Link')
        ;
    }

    public function testSubmitPasswordResetRequestInvalidEmail()
    {
        $this
            ->from(route(self::ROUTE_PASSWORD_REQUEST))
            ->post(route(self::ROUTE_PASSWORD_EMAIL), [
                'email' => Str::random(),
            ])
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
        $response = $this
            ->from(route(self::ROUTE_PASSWORD_REQUEST))
            ->post(route(self::ROUTE_PASSWORD_EMAIL), [
                'email' => $this->faker->unique()->safeEmail,
            ])
            ->assertSuccessful()
        ;
        $response->assertSeeText(__('passwords.user'));
    }

    /**
     * Testing submitting a password reset request.
     */
    public function testSubmitPasswordResetRequest()
    {
        $params = ['email' => $this->customer->email];
        $this
            ->from(route(self::ROUTE_PASSWORD_REQUEST))
            ->post(route(self::ROUTE_PASSWORD_EMAIL), $params)
            ->assertSuccessful()
            ->assertSeeText(__('passwords.sent'))
        ;
        Notification::assertSentTo($this->customer, ResetPassword::class);
    }

    public function testShowPasswordResetPage()
    {
        $token = Password::broker('customers')->createToken($this->createCustomerWithoutEvents());
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
        $token = Password::broker('customers')->createToken($this->createCustomerWithoutEvents());
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

        $this->customer->refresh();
        $this->assertFalse(Hash::check($password, $this->customer->password));
        $this->assertTrue(Hash::check('password', $this->customer->password));
    }

    /**
     * Testing submitting the password reset page with an email
     * address not in the database.
     */
    public function testSubmitPasswordResetEmailNotFound()
    {
        $token = Password::broker('customers')->createToken($this->createCustomerWithoutEvents());
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

        $this->customer->refresh();
        $this->assertFalse(Hash::check($password, $this->customer->password));
        $this->assertTrue(Hash::check('password', $this->customer->password));
    }

    /**
     * Testing submitting the password reset page with a password
     * that doesn't match the password confirmation.
     */
    public function testSubmitPasswordResetPasswordMismatch()
    {
        $token = Password::broker('customers')->createToken($this->createCustomerWithoutEvents());

        $password = Str::random();
        $password_confirmation = Str::random();
        $params = [
            'token' => $token,
            'email' => $this->customer->email,
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

        $this->customer->refresh();
        $this->assertFalse(Hash::check($password, $this->customer->password));
        $this->assertTrue(Hash::check('password', $this->customer->password));
    }

    /**
     * Testing submitting the password reset page with a password
     * that is not long enough.
     */
    public function testSubmitPasswordResetPasswordTooShort()
    {
        $token = Password::broker('customers')->createToken($this->createCustomerWithoutEvents());
        $password = Str::random(5);
        $params = [
            'token' => $token,
            'email' => $this->customer->email,
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

        $this->customer->refresh();
        $this->assertFalse(Hash::check($password, $this->customer->password));
        $this->assertTrue(Hash::check('password', $this->customer->password));
    }

    /**
     * Testing submitting the password reset page.
     */
    public function testSubmitPasswordReset()
    {
        $token = Password::broker('customers')->createToken($this->createCustomerWithoutEvents());
        $password = Str::random();
        $params = [
            'token' => $token,
            'email' => $this->customer->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];
        $this
            ->from(route(self::ROUTE_PASSWORD_RESET, ['token' => $token]))
            ->post(route(self::ROUTE_PASSWORD_RESET_SUBMIT, $params), $params)
            ->assertSuccessful()
        ;

        $this->customer->refresh();
        $this->assertAuthenticated(self::USER_GUARD);
        $this->assertFalse(Hash::check('password', $this->customer->password));
        $this->assertTrue(Hash::check($password, $this->customer->password));
    }
}
