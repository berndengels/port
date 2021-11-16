<?php
namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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

    /**
     * @var AdminUser $user
     */
    protected $user;
    /**
     * @var Customer $customer
     */
    protected $customer;
    protected $useNotTearDown = true;
    protected $followRedirects = true;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::clear();
        Notification::fake();
        DB::setDefaultConnection('testing');
        $this->artisan('migrate:fresh --drop-views --env=testing --path=database/migrations/testing');
        $this->artisan('db:seed --env=testing');
        $this
            ->createUser()
            ->createCustomer()
        ;
    }

    protected function tearDown(): void
    {
        if($this->useNotTearDown) {
            return;
        }
        parent::tearDown();
    }

    protected function createUser() {
        $this->user = AdminUser::factory()
            ->hasRoles(1, [
                'name'          => 'admin',
                'guard_name'    => 'admin',
            ])
            ->create();
        $this->user->guard(['admin'])->refresh();
        return $this;
    }

    protected function createCustomer() {
        $this->customer = Customer::factory()
            ->has(Boat::factory()
                ->has(BoatDates::factory()->count(3),'dates')
                ->count(1),'boats'
            )
            ->hasRoles(1, [
                'name'          => 'boat',
                'guard_name'    => 'web',
            ])
            ->create();
        $this->user->guard(['customer'])->refresh();
        return $this;
    }

    public function asFakeUser(...$permission): self
    {
        if($permission) {
            $this->user->givePermissionTo($permission);
        }
        $this->be($this->user, 'admin');
        return $this;
    }
    public function asFakeCustomer(string $permission = null): self
    {
        if($permission) {
            $this->customer->givePermissionTo($permission);
        }
        $this->be($this->customer, 'customer');
        return $this;
    }
}
