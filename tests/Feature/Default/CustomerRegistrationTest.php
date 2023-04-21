<?php
namespace Tests\Feature\Default;

use App\Models\Permission;
use App\Notifications\NewRegistrationDone;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;

class CustomerRegistrationTest extends TestCase
{
    use WithFaker;

    public const ROUTE_RREGISTER_REQUEST = 'register';
    public const ROUTE_RREGISTER_SUBMIT = 'register';
    public const ROUTE_DASHBOARD = 'public.dashboard';
    public const USER_GUARD = 'customer';

    private $params = [
        'guest' => [
            'type'      => 'guest',
            'name'      => 'Paul Meier',
            'email'     => 'paul@meier.de',
            'password'  => 'password',
            'password_confirmation' => 'password',
            'fon'       => '12345678',
            'street'    => 'Hauptstrasse 11',
            'postcode'  => '12998',
            'city'      => 'Hummelsbach',
            'captcha'   => '123',
        ],
        'permanent' => [
            'type'      => 'permanent',
            'name'      => 'Paul Dauerlieger',
            'email'     => 'paul@permanent.de',
            'password'  => 'password',
            'password_confirmation' => 'password',
            'fon'       => '12345678',
            'street'    => 'Hauptstrasse 11',
            'postcode'  => '12998',
            'city'      => 'Hummelsbach',
            'captcha'   => '123',
        ],
        'renter' => [
            'type'      => 'renter',
            'name'      => 'Paul Mieter',
            'email'     => 'paul@mieter.de',
            'password'  => 'password',
            'password_confirmation' => 'password',
            'fon'       => '12345678',
            'street'    => 'Hauptstrasse 11',
            'postcode'  => '12998',
            'city'      => 'Hummelsbach',
            'captcha'   => '123',
        ],
    ];

    public function testShowRegistrationPage()
    {
        $this
            ->get(route(self::ROUTE_RREGISTER_REQUEST))
            ->assertSuccessful()
            ->assertSeeText(__('Registrierung für Kunden'))
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
//            ->assertSeeText('Logout')
        ;
//        $this->assertAuthenticated('customer');
//        $this->assertDatabaseHas(Customer::class,['email' => $this->params['email']], 'testing');
    }

    public function testRegistrationDoneEventDispached() {
        Event::fake([Registered::class]);
        $this->createCustomer(confirmed: false, asRegistration: true, force: true);
        Event::assertDispatched(Registered::class);
    }

    public function testRegistrationDoneEventNotDispached() {
        Event::fake([Registered::class]);
        $this->createCustomer(confirmed: true, asRegistration: false, force: true);
        Event::assertNotDispatched(Registered::class);
    }

    public function testRegistrationDoneNotifyAdmin() {
        Notification::fake();
        $user = $this->user;
        $user->update(['email' => 'engels@f50.de']);
        $this->createCustomer(confirmed: false, asRegistration: true, force: true);
        Notification::assertSentTo(
            [$user], NewRegistrationDone::class
        );
    }

    public function testRegistrationDoneBoatCustomerHasRole() {
        Event::fake([Registered::class]);
        /**
         * @var $customer Customer
         */
        $customer = $this->createCustomer(confirmed: false, asRegistration: true, force: true);
        Event::assertDispatched(Registered::class);
        $customer->refresh();
        $this->assertTrue($customer->hasRole('boat'), 'Boat customer has no valid Role');
    }
/*
    public function testRegistrationDoneRenterCustomerHasRole() {
        Event::fake([Registered::class]);
        $customer = $this->createCustomer(confirmed: false, asRegistration: true, force: true);
        Event::assertDispatched(Registered::class);
        $customer->refresh();
        $this->assertTrue($customer->hasRole('renter'), 'Renter customer has no valid Role');
    }
*/
    public function testRegistrationDoneCustomerHasPermissions() {
        Event::fake([Registered::class]);
        /**
         * @var $customer Customer
         */
        $customer = $this->createCustomer(confirmed: false, asRegistration: true, force: true);
        $permissions = Permission::whereGuardName('customer')->get();
        Event::assertDispatched(Registered::class);
        $customer->refresh();
        $this->assertTrue($customer->hasAllPermissions($permissions), 'Customer has no valid Permissions');
    }
}
