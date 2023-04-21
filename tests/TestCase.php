<?php
namespace Tests;

use App\Models\Permission;
use App\Models\Role;
use App\Models\ServiceRequest;
use Database\Factories\AdminRoleFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Notification;
use App\Models\AdminUser;
use App\Models\Boat;
use App\Models\BoatDates;
use App\Models\Customer;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Cache;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $useNotTearDown = true;
    protected $followRedirects = true;
    /**
     * @var AdminUser
     */
    protected $user;
    /**
     * @var Customer
     */
    protected $customer;
    protected $env = 'testing';

    protected function setUp(): void
    {
        parent::setUp();
        Cache::clear();
        DB::setDefaultConnection($this->env);
        config()->set('database.default', $this->env);
        Notification::fake();
        $this->user = $this->getUser();
        $this->customer = $this->getCustomer();
    }

    protected function tearDown(): void
    {
        if($this->useNotTearDown) {
            return;
        }
        parent::tearDown();
    }

    protected function getUser() {
        return AdminUser::whereName('Bernd Engels')->first();
    }

    protected function getCustomer() {
        return Customer::whereName('Pamina')->first();
    }

    public function asFakeUser(...$permission): self
    {
        if(!$this->user) {
            $this->user = $this->getUser();
        }
        if($permission) {
            $this->user->givePermissionTo($permission);
        }
        $this->be($this->user, 'admin');
        return $this;
    }

    public function asFakeCustomer(string $permission = null, bool $confirmed = false): self
    {
        if(!$this->customer) {
            $this->customer = $this->getCustomer();
        }
        if($permission) {
//            $this->customer->givePermissionTo($permission);
        }
        $this->be($this->customer, 'customer');
        return $this;
    }
}
