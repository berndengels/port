<?php

namespace Tests\Unit;

use App\Http\Controllers\Auth\RegisterController;
use Bengels\LaravelEmailExceptions\Exceptions\EmailHandler;
use Illuminate\Auth\Events\Registered;
use Mockery;
use Exception;
use Tests\TestCase;

/**
 *
 */
class RegistrationTest extends TestCase
{

    /**
     * @var Mockery\Mock
     */
    protected $registrationMock;
    protected $eventMock;
    protected $notificationMock;

    /**
     * setUp Test, Mock
     */
    protected function setUp(): void
    {
        parent::setUp();
        // set up our registration handler mock
        $this->registrationMock = Mockery::mock(
            RegisterController::class
        )->makePartial()->shouldAllowMockingProtectedMethods();
        $this->eventMock = Mockery::mock(
            Registered::class
        )->makePartial()->shouldAllowMockingProtectedMethods();
        $this->notificationMock = Mockery::mock(
//            Registr
        )->makePartial()->shouldAllowMockingProtectedMethods();
    }

    /**
     * @dataProvider registrationDataProvider
     */
    public function testRegistrationNotification()
    {

    }

    private  function  registrationDataProvider()
    {
        return [
            'valid data' => [
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
            ],
        ];
    }
}
