<?php

namespace App\Providers;

use App\Listeners\StoreAccessLog;
use App\Models\Customer;
use App\Events\ServiceRequested;
use App\Listeners\SendRegisterEmailNotification;
use App\Listeners\ServiceRequestNotification;
use App\Listeners\SetCustomerRegistredPermissions;
use App\Observers\CustomerObserver;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendRegisterEmailNotification::class,
            SetCustomerRegistredPermissions::class,
        ],
        ServiceRequested::class => [
            ServiceRequestNotification::class,
        ],
        Authenticated::class => [
            StoreAccessLog::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Customer::observe(CustomerObserver::class);
    }
}
