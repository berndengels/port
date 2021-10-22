<?php

namespace App\Providers;

use App\Listeners\SendInvoiceEmailNotification;
use App\Listeners\SendRegisterEmailNotification;
use App\Models\BoatDates;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
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
        //
    }
}
