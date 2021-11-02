<?php
namespace Tests;

use App\Models\AdminUser;
use App\Models\Customer;
use App\Models\Permission;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Console\Application as Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Queue\Queue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Str;
use Mockery\Exception\InvalidCountException;
use Mockery;

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
    protected $useNotTearDown = false;
    protected $followRedirects = true;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::clear();
        $this->artisan('migrate:fresh --drop-views --database=testing --env=testing --path=database/migrations/testing');
        $this->artisan('db:seed --database=testing --env=testing');
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

        if ($this->app) {
            $this->callBeforeApplicationDestroyedCallbacks();
            ParallelTesting::callTearDownTestCaseCallbacks($this);
            $this->app->flush();
            $this->app = null;
        }

        $this->setUpHasRun = false;

        if (property_exists($this, 'serverVariables')) {
            $this->serverVariables = [];
        }
        if (property_exists($this, 'defaultHeaders')) {
            $this->defaultHeaders = [];
        }
        if (class_exists('Mockery')) {
            if ($container = Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }
            try {
                Mockery::close();
            } catch (InvalidCountException $e) {
                if (! Str::contains($e->getMethodName(), ['doWrite', 'askQuestion'])) {
                    throw $e;
                }
            }
        }

        if (class_exists(Carbon::class)) {
            Carbon::setTestNow();
        }
        if (class_exists(CarbonImmutable::class)) {
            CarbonImmutable::setTestNow();
        }
        $this->afterApplicationCreatedCallbacks = [];
        $this->beforeApplicationDestroyedCallbacks = [];

        Artisan::forgetBootstrappers();
        Queue::createPayloadUsing(null);
    }

    protected function createUser() {
        $this->user = AdminUser::factory()
            ->hasRoles(1, [
                'name'          => 'admin',
                'guard_name'    => 'admin',
            ])
            ->create();
        return $this;
    }

    protected function createCustomer() {
        $this->customer = Customer::factory()
            ->hasRoles(1, [
                'name'          => 'boat',
                'guard_name'    => 'web',
            ])
            ->create();
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
        $this->be($this->customer, 'web');
        return $this;
    }
}
