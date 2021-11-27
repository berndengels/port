<?php

namespace App\Providers;

use App\Events\ServiceRequested;
use App\Listeners\SendInvoiceEmailNotification;
use App\Listeners\SendRegisterEmailNotification;
use App\Listeners\ServiceRequestNotification;
use App\Models\BoatDates;
use App\Models\Customer;
use App\Observers\CustomerObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        ],
        ServiceRequested::class => [
            ServiceRequestNotification::class,
        ],
        /*
        'boatDates.created' => [
            SendInvoiceEmailNotification::class,
        ],
        'boatDates.updated' => [
            SendInvoiceEmailNotification::class,
        ],
        'boatDates.saved' => [
            SendInvoiceEmailNotification::class,
        ],
        */
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
