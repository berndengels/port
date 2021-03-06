<?php
namespace Tests;

use App\Models\Permission;
use App\Models\Role;
use App\Models\ServiceRequest;
use Database\Factories\AdminRoleFactory;
use Database\Factories\CustomerRoleFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Mockery;
use Notification;
use Carbon\Carbon;
use App\Models\AdminUser;
use App\Models\Boat;
use App\Models\BoatDates;
use App\Models\Customer;
use Carbon\CarbonImmutable;
use Illuminate\Console\Application as Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Str;
use Mockery\Exception\InvalidCountException;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $useNotTearDown = true;
    protected $followRedirects = true;
    protected $user;
    protected $customer;
    protected $env = 'testing';

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
        Cache::clear();
        DB::setDefaultConnection($this->env);
        $migrationPath = 'testing' === $this->env ? '/testing' : '';

        $this->artisan("migrate:fresh --drop-views --env=$this->env --path=database/migrations". $migrationPath);
        $this->artisan("db:seed --env=$this->env");

        $this->user     = $this->createUserWithoutEvents();
        $this->customer = $this->createCustomerWithoutEvents();
    }

    protected function tearDown(): void
    {
        if($this->useNotTearDown) {
            return;
        }
        parent::tearDown();
    }

    protected function createUser($force = false): AdminUser {
        $factory = AdminUser::factory();

        if(0 === Role::whereName('admin')->whereGuardName('admin')->count()) {
            $factory = $factory->has((new AdminRoleFactory())->count(1),'roles');
        }

        $email = $factory->definition()['email'];
        if(!$force && $user = AdminUser::whereEmail($email)->first()) {
            return $user;
        }

        $user = $factory->create();
        $user
            ->guard(['admin'])
            ->givePermissionTo(Permission::whereGuardName('admin')->get())
            ->refresh()
        ;
        return $user;
    }

    protected function createCustomer(bool $confirmed = false, bool $asRegistration = false, $force = false) {


        $factory =  Customer::factory()
            ->state(fn (array $attr) => ['confirmed' => $confirmed])
            ->has(Boat::factory()
                ->has(BoatDates::factory()->count(3),'dates')
                ->has(ServiceRequest::factory()->count(1), 'serviceRequests')
                ->count(1),'boats'
            )
        ;

        $email = $factory->definition()['email'];
        if(!$force && $customer = Customer::whereEmail($email)->first()) {
            return $customer;
        }

        $customer = $factory->create();

        if($asRegistration) {
            Event::dispatch(new Registered($customer));
        }

        return $customer;
    }

    public function createUserWithoutEvents(): AdminUser {
        return AdminUser::withoutEvents(fn() => $this->createUser());
    }

    public function createCustomerWithoutEvents(bool $confirmed = false): Customer {
        return Customer::withoutEvents(fn() => $this->createCustomer($confirmed));
    }

    public function asFakeUser(...$permission): self
    {
        $user = $this->user;
        if($permission) {
            $user->givePermissionTo($permission);
        }
        $this->be($user, 'admin');
        return $this;
    }

    public function asFakeCustomer(string $permission = null, bool $confirmed = false): self
    {
        $customer = $this->customer;
        if($permission) {
//            $customer->givePermissionTo($permission);
        }
        $this->be($customer, 'customer');
        return $this;
    }
}
