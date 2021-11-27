<?php
namespace Tests\Feature;

use App\Notifications\NewRegistrationDone;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Mews\Captcha\Captcha;
use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Listeners\SendRegisterEmailNotification;

class CustomerRegistrationTest extends TestCase
{
    use WithFaker;

    const ROUTE_RREGISTER_REQUEST   = 'register';
    const ROUTE_RREGISTER_SUBMIT    = 'register';
    const ROUTE_DASHBOARD           = 'public.dashboard';
    const USER_GUARD                = 'customer';

    private $params = [
        'name'      => 'Paul Meier',
        'email'     => 'paul@meier.de',
        'password'  => 'password',
        'password_confirmation' => 'password',
        'fon'       => '12345678',
        'street'    => 'Hauptstrasse 11',
        'postcode'  => '12998',
        'city'      => 'Hummelsbach',
        'boat_type' => 'sail',
        'boat_name' => 'Ohne Yoko',
        'length'    => '10',
        'width'     => '3',
        'weight'    => '4000',
        'draft'     => '1.6',
        'length_waterline' => '9',
        'length_keel'      => '2',
        'mast_length'      => '11',
        'mast_weight'      => '100',
    ];

    public function testShowRegistrationPage()
    {
        $this
            ->get(route(self::ROUTE_RREGISTER_REQUEST))
            ->assertSuccessful()
            ->assertSeeText(__('Registrierung für Dauerlieger'))
            ->assertSeeText(__('Register'))
        ;
    }

    /**
     * Testing submitting the registration page with an empty name.
     */
    public function testSubmitRegistrationEmptyName()
    {
        $this->params['name'] = '';
        $this
            ->followingRedirects()
            ->from(route(self::ROUTE_RREGISTER_REQUEST))
            ->post(route(self::ROUTE_RREGISTER_SUBMIT, $this->params), $this->params)
            ->assertSuccessful()
            ->assertSeeText(__('validation.required', [
                'attribute' => 'name',
            ]));
    }

    /**
     * Testing submitting the registration page with an invalid
     * email address.
     */
    public function testSubmitRegistrationInvalidEmail()
    {
        $this->params['email'] = Str::random();
        $this
            ->followingRedirects()
            ->from(route(self::ROUTE_RREGISTER_REQUEST))
            ->post(route(self::ROUTE_RREGISTER_SUBMIT, $this->params), $this->params)
            ->assertSuccessful()
            ->assertSeeText(__('validation.email', [
                'attribute' => 'email',
            ]));
    }

    /**
     * Testing submitting the registration page with a password
     * that doesn't match the password confirmation.
     */
    public function testSubmitRegistrationPasswordMismatch()
    {
        $this->params['password'] = Str::random();
        $this->params['password_confirmation'] = Str::random();
        $this
            ->followingRedirects()
            ->from(route(self::ROUTE_RREGISTER_REQUEST))
            ->post(route(self::ROUTE_RREGISTER_SUBMIT, $this->params), $this->params)
            ->assertSuccessful()
            ->assertSee(__('validation.confirmed', [
                'attribute' => 'password',
            ]));
    }

    /**
     * Testing submitting a valid registration request.
     */
    public function testSubmitRegistrationRequest()
    {
        $this
            ->from(route(self::ROUTE_RREGISTER_REQUEST))
            ->post(route(self::ROUTE_RREGISTER_SUBMIT, $this->params), $this->params)
            ->assertSuccessful()
            ->assertSeeText('Logout')
        ;
        $this->assertAuthenticated('customer');
        $this->assertDatabaseHas(Customer::class,['email' => $this->params['email']], 'testing');
    }

    public function testRegistrationDoneEventDispached() {
        Event::fake([Registered::class]);
        $this->createCustomer(confirmed: false, asRegistration: true);
        Event::assertDispatched(Registered::class);
    }

    public function testRegistrationDoneEventNotDispached() {
        Event::fake([Registered::class]);
        $this->createCustomer(confirmed: true, asRegistration: false);
        Event::assertNotDispatched(Registered::class);
    }

    public function testRegistrationDoneNotifyAdmin() {
        Notification::fake();
        $user = $this->user;
        $user->update(['email' => 'engels@f50.de']);

        $this->createCustomer(confirmed: false, asRegistration: true);

        Notification::assertSentTo(
            [$user], NewRegistrationDone::class
        );
    }
}
